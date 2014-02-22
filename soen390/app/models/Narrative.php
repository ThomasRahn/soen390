<?php 

class Narrative extends Eloquent
{

    protected $table      = 'Narrative';
    protected $primaryKey = 'NarrativeID';
    protected $softDelete = true;
    protected $guarded    = array('id');
    public    $timestamps = false;

    public function category()
    {
        return $this->belongsTo('Category', 'CategoryID', 'CategoryID');
    }

    public function language()
    {
        return $this->belongsTo('Language', 'LanguageID', 'LanguageID');
    }

    public function content()
    {
        return $this->hasMany('Content', 'NarrativeID', 'NarrativeID');
    }

    public function media()
    {
        return $this->hasMany('Media', 'narrative_id', 'NarrativeID');
    }

    /**
     * Creates all Narratives found in an uploaded archive.
     *
     * A directory containing a Narrative is assumed to be made up of a XML
     * file, one-to-many audio files, and zero-to-many image files.
     *
     * The XML file should contain the meta-data associated with the
     * narrative.
     *
     * The $name should be a unique indentifier for this particular archive.
     * Multiple instances of this archive should each have _different_ $name
     * values.
     *
     * The $category parameter should be the primary ID of the Category for
     * which all narratives in the archive will be associated to.
     *
     * The $published value will determine whether each Narrative found will
     * be made available for viewing by end-users.
     *
     * @param  string  $name
     * @param  string  $path
     * @param  integer $category
     * @param  boolean $publish
     * @return void
     */
    public static function addArchive($name, $path, $category, $publish)
    {
        // Extract the specified archive and retrieve the output path.
        $outputPath = self::extractArchive($name, $path);

        // Process the extracted contents for narratives and create them
        // individually.
        self::findNarratives($outputPath, $category, $publish);
    }

    /**
     * Extracts a ZIP archive specified at $path into a new directory
     * defined by $name. Returns the path to the directory containing
     * the extracted contents.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    private static function extractArchive($name, $path)
    {
        // Determine the path for the directory that should contain
        // the extracted content.
        $outputPath = Config::get('media.paths.extracted')
                                . DIRECTORY_SEPARATOR
                                . escapeshellcmd($name);

        // Attempt to create the directory at the determined path.
        // If it fails, then throw an exception.
        if (! File::makeDirectory($outputPath, 0775, true))
            throw new RuntimeException('Unable to create output directory for archive at "' . $outputPath . '"');

        // Create a new ZipArchive instance and open/extract the archive.

        $archive = new ZipArchive();

        if (! $archive->open($path))
            throw new RuntimeException('Unable to open archive "' . $path . '"');

        if (! $archive->extractTo($outputPath))
            throw new RuntimeException('Unable to extract archive at "' . $path . '" to directory "' . $outputPath . '"');

        $archive->close();

        // Try to delete the original archive file, unless we're in debug mode.
        if (! Config::get('app.debug'))
            File::delete($path);

        return $outputPath;
    }

    /**
     * Goes through $path recursively and looks for valid narratives to
     * process.
     *
     * The $category should be the primary ID of the Category for which
     * all narratives found will be associated with.
     *
     * The $publish attribute specifies whether or not all created
     * narratives will be made available for public viewing at creation.
     *
     * @param  string  $path
     * @param  integer $category
     * @param  boolean $publish
     * @return void
     */
    private static function findNarratives($path, $category, $publish)
    {
        // Look for directories in this $path
        $directories = File::directories($path);

        // If there are sub-directories, then go into them recursively
        // and parse them. If we're looking at plain files, then $path
        // is a container for a narrative in which case, we process it.

        if (count($directories) > 0) {

            // Go into each one to find a narrative.
            foreach ($directories as $d)
                self::findNarratives($d, $category, $publish);

        } else {

            // Process a potential narrative.
            return self::processNarrative($path, $category, $publish);

        }
    }

    /**
     * Checks if $path contains a valid narrative. If it does, then a
     * Narrative instance will be created and the associated media files
     * will be processed.
     *
     * The $category should be the primary ID of the Category for which
     * all narratives found will be associated with.
     *
     * The $publish attribute specifies whether or not all created
     * narratives will be made available for public viewing at creation.
     *
     * @param  string  $path
     * @param  integer $category
     * @param  boolean $publish
     * @return void
     */
    private static function processNarrative($path, $category, $publish)
    {
        // Look for files in this $path
        $files = File::files($path);

        // If $path doesn't contain anything, then log the occurance and
        // return.

        if (count($files) === 0)
            return Log::info('Potential narrative container turned up empty: "' . $path . '"');

        // Look for the XML meta-data file. If it doesn't exist, then this
        // isn't a valid narrative container. Log the error and return.

        $xmlFilePath = null;

        foreach ($files as $f)
            if (File::extension($f) == 'xml') {
                $xmlFilePath = $f;
                break;
            }

        if ($xmlFilePath == null)
            return Log::info('Potential narrative container is missing an XML file: "' . $path . '"');

        // So we have an XML file. Are there any other files?
        // If there aren't any, then this narrative container is incomplete.

        if (count($files) == 1)
            return Log::error('Narrative container is missing media: "' . $path . '"');

        // Alright, we've made it through the checks and now we should have
        // a complete and valid narrative container.

        // Create the narrative and retrieve the instance.
        $narrative = self::createFromXML($xmlFilePath, $category, $publish);

        // We no longer need the XML file, so we'll attempt to delete it
        // unless we're in debug mode.
        if (! Config::get('app.debug'))
            File::delete($xmlFilePath);

        // Now that the narrative has been created, we need to process its
        // media files.
        return self::processMedia($path, $narrative);
    }

    /**
     * Creates a narrative instance from an XML meta-data file at $xmlFilePath.
     *
     * The $category should be the primary ID of the Category for which
     * all narratives found will be associated with.
     *
     * The $publish attribute specifies whether or not all created
     * narratives will be made available for public viewing at creation.
     *
     * @param  string  $xmlFilePath
     * @param  integer $category
     * @param  boolean $publish
     * @return Narrative
     */
    private static function createFromXML($xmlFilePath, $category, $publish = false)
    {
        // Let's parse the XML file and create a Narrative instance.

        $xmlFileElement = new SimpleXMLElement( File::get($xmlFilePath) );

        // Let's see if we can retrieve the appropriate language instance.

        $language = Language::where('Description', 'like', $xmlFileElement->language)->first();

        // If we don't have the appropriate language, throw an exception.
        if (! $language)
            throw new RuntimeException('Narrative references unknown language: "' . $xmlFilePath . '"');

        // Create the narrative instance with the data.
        $narrative = Narrative::create(array(
                'Name'        => $xmlFileElement->narrativeName,
                'TopicID'     => Topic::first()->TopicID,
                'CategoryID'  => $category,
                'LanguageID'  => $language->LanguageID,
                'DateCreated' => DateTime::createFromFormat(
                        'Y-m-d H-i-s',
                        $xmlFileElement->submitDate
                            . ' '
                            . $xmlFileElement->time
                    ),
                'Published'   => $publish,
            ));

        // If the narrative couldn't be created, throw an exception.
        if (! $narrative)
            throw new RuntimeException('Narrative could not be instantiated: "' . $xmlFilePath . '"');

        return $narrative;
    }

    /**
     * Processes all the media files in $path for the $narrative.
     *
     * All image and audio media types will be handled. Audio files will be
     * queued for transcoding.
     * 
     * @param  string     $path
     * @param  Narrative  $narrative
     * @return void
     */
    private static function processMedia($path, $narrative)
    {
        // Determine the path to the directory that will hold all the
        // processed media files.
        $mediaOutputPath = Config::get('media.paths.processed')
                                . DIRECTORY_SEPARATOR
                                . $narrative->NarrativeID;

        // Attempt to create the directory at the determined path. If we're
        // unable to, then throw an exception.
        if (! File::makeDirectory($mediaOutputPath, 0775, true))
            throw new RuntimeException('Unable to create directory to hold media files at "' . $mediaOutputPath . '"');

        // Create an `finfo` instance in order to figure out what each file is.
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        // Get all the files in $path
        $files = File::files($path);

        // Go through each file and figure out what to do with each one.
        foreach ($files as $f) {

            // Retrieve the MIME type for $f
            $mimeType = $finfo->file($f);

            // If $f is an image, then process it accordingly.
            if (strpos($mimeType, 'image/') === 0)
                self::processImageMedia($f, $narrative, $mediaOutputPath);

            // If $f is an audio, then process it accordingly.
            if (strpos($mimeType, 'audio/') === 0)
                self::processAudioMedia($f, $narrative);

        }

        return;
    }

    /**
     * Processes the image at $path for $narrative.
     *
     * The image will be moved into the $destination directory and a Media 
     * instance will be created and associated to $narrative.
     *
     * If the image is unable to be moved, then `null` will be returned.
     *
     * @param  string     $path
     * @param  Narrative  $narrative
     * @param  string     $destination
     * @return Media|null
     */
    private static function processImageMedia($path, $narrative, $destination) {
        // Retrieve details about the image $path
        $pathinfo = pathinfo($path);

        // Retrieve the filename (e.g. 'image.jpg' => 'image')
        $filename = $pathinfo['filename'];

        // Retrieve the basename (e.g. '../image.jpg' => 'image.jpg')
        $basename = $pathinfo['basename'];

        // Determine the destination path for this image
        $imageDestination = $destination . DIRECTORY_SEPARATOR . $basename;

        // Attempt to move the image to the determined path. If an error
        // occurs, then log the error and return.
        if (! File::move($path, $imageDestination)) {
            Log::error('Unable to move image from "' . $path . '" to "' . $imageDestination . '"');

            return null;
        }

        // Create the media instance for this image.
        return Media::create(array(
                'narrative_id' => $narrative->NarrativeID,
                'type'         => 'image',
                'filename'     => $filename,
                'basename'     => $basename,
            ));
    }

    /**
     * Processes the audio at $path for $narrative.
     *
     * The audio will be queued for transcoding, where it will be
     * transcoded, stored into the appropriate destination, and a Media
     * instance will be created and associated with $narrative.
     *
     * @param  string     $path
     * @param  Narrative  $narrative
     * @return void
     */
    private static function processAudioMedia($path, $narrative) {
        // Queue the audio file for transcoding via the `TranscodeAudio`
        // function, using the `transcoding` queue pipe.
        return Queue::push('TranscodeAudio', array(
                'sourceFilePath' => $path,
                'narrativeID'    => $narrative->NarrativeID,
            ),'transcoding');
    }

}
