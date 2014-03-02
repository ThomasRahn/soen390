<?php

/**
 * @author Alan Ly <me@alanly.ca>
 */
class TranscodeAudio
{
    public function fire($job, $data)
    {
    	$transcodeEnabled = Config::get('media.transcode');

        // Retrieve the given details
        $sourceFilePath = $data['sourceFilePath'];
        $narrativeID = $data['narrativeID'];

        $pathinfo = pathinfo($sourceFilePath);

        // Determine the filename
        $fileName = $pathinfo['filename'];

        // Determine the original format
        $sourceExtension = $pathinfo['extension'];

        // Determine the source directory path
        $sourceDirPath = $pathinfo['dirname'];

        // Specify the desired output formats (extension => codec)
        $outputFormats = Config::get('media.transcode_formats');

        // Determine the duration of the source audio.

        $durationString = Sonus::getMediaInfo($sourceFilePath)['format']['duration'];

        sscanf($durationString, "%d:%d:%d.%s", $dHours, $dMinutes, $dSeconds, $dMicroseconds);

        $dSeconds += ($dHours * 3600) + ($dMinutes * 60);
        $parsedDuration = $dSeconds . '.' . $dMicroseconds;

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

            // If the source file is already in the desired $codec,
            // then we'll just move it and skip transcoding to $codec.

            if (strtolower($sourceExtension) == $extension) {

                File::move($sourceFilePath, $outputPath);

            } else {

                // Begin transcoding
                Sonus::convert()
                    ->input($sourceFilePath)
                    ->output($outputPath)
                    ->go('-acodec ' . $codec . ' -ab 64k -ar 44100');

            }

            // Once completed, create the Content object for the output.
            Media::create(array(
                'narrative_id' => $narrativeID,
                'type' => 'audio',
                'filename' => $fileName,
                'basename' => $baseName,
                'audio_codec' => $extension,
                'audio_duration' => $parsedDuration,
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
