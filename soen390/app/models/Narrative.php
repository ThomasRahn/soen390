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
	 * @param  $name        string
	 * @param  $archivePath string
	 * @return void
	 */
	public static function addArchive($name, $archivePath)
	{
		// Extract the archive into folder named by $name
		$extractedPath = self::extractArchive($name, $archivePath);
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
		$destPath = Config::get('media.paths.extracted') . '/' . escapeshellcmd($name);

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
}
