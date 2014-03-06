<?php

class MediaTest extends TestCase
{

	/*
	*
	*	@covers Media::narrative
	*/
	public function testMediaNarrativeRelationship(){
		
		$narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = 1;
        $narrativeCreated->LanguageID = 1;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

        $media = new Media;
        $media->id = 1;
        $media->filename = "hello";
        $media->basename = "hello";
        $media->type = "audio";
        $media->save();

        $narrative = Media::find(1)->narrative();
        $this->assertNotNull($narrative);
	}

	/*
	*	tests Media filter by audio
	*	@covers Media::scopeAudio
	*/
	public function testMediaAudio(){

		$media = new Media;
        $media->id = 1;
        $media->filename = "hello";
        $media->basename = "hello";
        $media->type = "audio";
        $media->save();

        $media = Media::audio();
        $this->assertTrue($media->count() > 0);
	}
	/*
	*	tests Media filter by image
	*	@covers Media::scopeImages
	*/
	public function testMediaImage(){

		$media = new Media;
        $media->id = 1;
        $media->filename = "hello";
        $media->basename = "hello";
        $media->type = "image";
        $media->save();

        $media = Media::images();
        $this->assertTrue($media->count() > 0);
	}

}