<?php

class ContentControllerTest extends TestCase
{

	/*
	*
	*
	* ContentController::getContent
	*/
	public function testGetContent(){
		$media = new Media;
        $media->id = 1;
        $media->filename = "1.mp3";
        $media->basename = "test";
        $media->type = "audio";
        $media->save();


	}

}