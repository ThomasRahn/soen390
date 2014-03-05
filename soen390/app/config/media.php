<?php

return array(

    /**
     * Defines whether or not uploaded audio should be transcoded.
     * If set to false, the original source audio will just be moved if it's
     * audio format is covered by the `transcode_formats` configuration
     * directive below.
     */
    'transcode' => true,

    /**
     * If `transcode` is enabled, then source files will be transcoded into
     * the following formats if necessary.
     *
     * The file extension to the (ffmpeg supported) codec should be mapped
     * from <extension> => <codec>.
     */
    'transcode_formats' => array(
        'ogg' => 'libvorbis',
        'mp3' => 'libmp3lame',
    ),

	'paths' => array(
		'uploads' => __DIR__ . '/../storage/media/uploads',
		'extracted' => __DIR__ . '/../storage/media/extracted',
		'processed' => __DIR__ . '/../storage/media/processed',
	),

);
