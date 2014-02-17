<?php 

class Narrative extends Eloquent
{
	protected $table = 'Narrative';
	protected $primaryKey = 'NarrativeID';
	protected $softDelete = true;
	protected $guarded = array('id');
	public $timestamps = false;

	public function category()
	{
		return $this->belongsTo('Category', 'CategoryID', 'CategoryID');
	}

	public function langauge()
	{
		return $this->belongsTo('Language', 'LanguageID', 'LanguageID');
	}

	public function content()
	{
		return $this->hasMany('Content', 'NarrativeID', 'NarrativeID');
	}

	/**
	 * Processes raw narratives stored within a compressed archive.
	 *
	 * Archived narratives are expected to be extracted into the 
	 * following structure:
	 *
	 *   ./
	 *     ./1/
	 *       ./1/1.jpg
	 *       ./1/2.jpg
	 *       ./1/[...].jpg
	 *       ./1/1.mp3
	 *       ./1/1.xml
	 *     ./[...]/
	 *
	 * The archive should have an identifying $name string that is
	 * unique to its particular instance. Multiple instances of the
	 * same archive should each have their own $name values.
	 *
	 * @param  $name            string
	 * @param  $archivePath     string
	 * @param  $defaultCategory int
	 * @return void
	 */
	public static function addArchive($name, $archivePath, $defaultCategory)
	{
		// Extract the archive into folder named by $name
		$extractedPath = self::extractArchive($name, $archivePath);

		// Go through the extracted contents and process them.
		self::processExtractedArchive($extractedPath, $defaultCategory);
	}

	/**
	 * Extracts the specified archive at $archivePath into the
	 * subdirectory defined by $name.
	 *
	 * @param  $name        string
	 * @param  $archivePath string
	 * @return string
	 */
	private static function extractArchive($name, $archivePath)
	{
		// Create containing directory.
		$destPath = Config::get('media.paths.extracted') . DIRECTORY_SEPARATOR . escapeshellcmd($name);

		if (mkdir($destPath, 0775, true) === false)
			throw new RuntimeException('Unable to create directory: "' . $destPath . '"');

		$archive = new ZipArchive();

		if ($archive->open($archivePath) !== true)
			throw new RuntimeException('Unable to open archive: "' . $archivePath . '"');

		if ($archive->extractTo($destPath) === false)
			throw new RuntimeException('Unable to extract archive "' . $archivePath . '" to destination "' . $destPath . '"');

		$archive->close();

		// If application is in debug mode, do not delete the original archive.
		if (Config::get('app.debug') === false)
			unlink($archivePath);

		return $destPath;
	}

	/**
	 * Processes an archive that has been extracted.
	 *
	 * This will go through the directory structure, creating the necessary
	 * Narrative objects and any associated Content. Narratives will be
	 * associated with a default Category that is specified.
	 *
	 * @param  $extractedPath   string
	 * @param  $defaultCategory int
	 * @return void
	 */
	private static function processExtractedArchive($extractedPath, $defaultCategory)
	{
		// Get all subdirectories, which should each be a self-contained
		// narrative.
		$narratives = File::directories($extractedPath);

		if (count($narratives) === 0) {
			Log::info('Empty archive.', array('context' => 'Archive path: "' . $extractedPath . '"'));
			return;
		}

		// Process each narrative individually
		foreach ($narratives as $narPath) {
			// Get all files in the narrative
			$files = File::files($narPath);

			// The narrative identifier should be the value of the subdirectory.
			$narId = basename($narPath);

			// Based on the identifier, there should be an associated XML file within.
			$metaFilePath = $narPath . DIRECTORY_SEPARATOR . $narId . '.xml';

			if (! File::exists($metaFilePath)) {
				Log::error(
					'Narrative is missing appropriate metadata file.',
					array('context' => $narPath)
				);
				continue;
			}

			if (count($files) < 2) { // Make sure that there's more than just a metafile.
				Log::error(
					'Narrative is missing media files.',
					array('context' => $narPath)
				);
				continue;
			}

			// Retrieve the metadata file and parse it.
			$metaFile = File::get($metaFilePath);
			$metaXmlElement = new SimpleXMLElement($metaFile);

			// Create a new Narrative based on the metadata.
			$language = Language::where('Description', 'like', $metaXmlElement->language)->first(); // Retrieve the associated language
			$narrative = Narrative::create(array(
				'Name' => $metaXmlElement->narrativeName,
				'TopicID' => Topic::first()->TopicID,
				'CategoryID' => $defaultCategory,
				'LanguageID' => $language->LanguageID,
				'DateCreated' => DateTime::createFromFormat('Y-m-d H-i-s', ($metaXmlElement->submitDate . ' ' . $metaXmlElement->time))->getTimestamp(),
			));

			// Delete the metafile unless application is in debug mode.
			if (Config::get('app.debug') === false)
				if (File::delete($metaFilePath) === false)
					Log::error('Unable to delete metafile.', array('context' => $metaFilePath));

			// Create a directory to hold all processed media associated with this narrative.
			$processedPath = Config::get('media.paths.processed') . DIRECTORY_SEPARATOR . $narrative->NarrativeID;

			if (File::makeDirectory($processedPath, 0775, true) === false)
				throw new RuntimeException('Unable to create directory: "' . $processedPath . '"');

			$finfo = new finfo(FILEINFO_MIME_TYPE);

			// Go through each file
			foreach ($files as $filePath) {
				// Skip the XML
				if (File::extension($filePath) === 'xml') continue;

				// Get the MIME type of the file
				$fileMime = $finfo->file($filePath);

				// If the file is an 'image', then move it.
				if (strpos($fileMime, 'image/') === 0) {
					$fileName = basename($filePath);
					$fileDestPath = $processedPath . DIRECTORY_SEPARATOR . $fileName;
					File::move($filePath, $fileDestPath);

					// Create the associated Content
					Content::create(array(
						'NarrativeID' => $narrative->NarrativeID,
						'PicturePath' => $fileName,
					));
				}

				// If the file is an 'audio', then process it further.
				if (strpos($fileMime, 'audio/') === 0) {
					// Queue file for processing
					Queue::push('TranscodeAudio', array(
						'sourceFilePath' => $filePath,
						'narrativeID' => $narrative->NarrativeID,
					), 'transcoding');
				}
			}
		}
	}
}
