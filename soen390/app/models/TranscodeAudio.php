<?php

class TranscodeAudio
{
	public function fire($job, $data)
	{
		// Retrieve the given details
		$sourceFilePath = $data['sourceFilePath'];
		$narrativeID = $data['narrativeID'];

		$pathinfo = pathinfo($sourceFilePath);

		// Determine the filename
		$fileName = $pathinfo['filename'];

		// Determine the source directory path
		$sourceDirPath = $pathinfo['dirname'];

		// Specify the desired output formats (extension => codec)
		$outputFormats = array(
			'ogg' => 'libvorbis',
			'mp3' => 'libmp3lame',
		);

		// Create a version of the source file for each format specified.
		foreach ($outputFormats as $extension => $codec) {
			// Determine the output basename
			$baseName = $fileName . '.' . $extension;

			// Determine the full output path
			$outputPath = Config::get('media.paths.processed')
				. DIRECTORY_SEPARATOR 
				. $narrativeID 
				. DIRECTORY_SEPARATOR 
				. $baseName;

			// Begin transcoding
			Sonus::convert()
				->input($sourceFilePath)
				->output($outputPath)
				->go('-acodec ' . $codec . ' -ab 64k -ar 44100');

			// Once completed, create the Content object for the output.
			Content::create(array(
				'NarrativeID' => $narrativeID,
				'AudioPath' => $baseName,
			));
		}

		// If application is not in debug mode, let's clean up.
		if (Config::get('app.debug') === false) {
			// Delete source file
			File::delete($sourceFilePath);

			// Check if source directory is empty...
			if (count(File::files($sourceDirPath)) === 0)
				File::deleteDirectory($sourceDirPath);
		}

	}
}

