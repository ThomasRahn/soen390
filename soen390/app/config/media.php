<?php

return array(

    /**
     * Defines whether or not uploaded audio should be transcoded.
     * If set to false, the original source audio will just be moved.
     */
    'transcode' => true,

	'paths' => array(
		'uploads' => __DIR__ . '/../storage/media/uploads',
		'extracted' => __DIR__ . '/../storage/media/extracted',
		'processed' => __DIR__ . '/../storage/media/processed',
	),

);
