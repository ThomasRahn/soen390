<?php

class NarrativeTest extends TestCase
{

    /**
     * Test to ensure that the archive is extracted properly.
     *
     * @covers Narrative::addArchive
     * @covers Narrative::extractArchive
     * @covers Narrative::processMedia
     * @covers Narrative::processAudioMedia
     */
    public function testExtractArchive()
    {
        // This should refer to the narrative bundle for unit testing.
        $narrativeBundle = Config::get('media.paths.uploads')
            . DIRECTORY_SEPARATOR
            . 'unit_testing_narrative_bundle.zip';

        $this->assertTrue(File::exists($narrativeBundle), 'The narrative bundle for unit testing is missing.');

        $name = time();

        // Mock the audio transcoding so that we don't spend any time
        // waiting for things to transcode.
        Queue::shouldReceive('push')->times(8)->andReturn(true);

        $narrative = new Narrative;
        $narrative->addArchive(
                $name,
                $narrativeBundle,
                Category::first()->CategoryID,
                true,
                Topic::first()->TopicID
            );

        $extractedPath = Config::get('media.paths.extracted') 
                . DIRECTORY_SEPARATOR
                . $name;

        $this->assertFileExists($extractedPath);

        $directories = File::directories($extractedPath);

        $this->assertCount(1, $directories);

        File::deleteDirectory($extractedPath);
    }

    /**
     * Test to ensure that extracted narratives are processed and found.
     *
     * @covers Narrative::addArchive
     * @covers Narrative::extractArchive
     * @covers Narrative::findNarratives
     * @covers Narrative::processNarrative
     * @covers Narrative::createFromXML
     * @covers Narrative::processMedia
     * @covers Narrative::processAudioMedia
     */
    public function testProcessNarratives()
    {
        // This should refer to the narrative bundle for unit testing.
        $narrativeBundle = Config::get('media.paths.uploads')
            . DIRECTORY_SEPARATOR
            . 'unit_testing_narrative_bundle.zip';

        $this->assertTrue(File::exists($narrativeBundle), 'The narrative bundle for unit testing is missing.');

        $name = time();

        // Mock the audio transcoding so that we don't spend any time
        // waiting for things to transcode.
        Queue::shouldReceive('push')->times(8)->andReturn(true);

        $narrative = new Narrative;
        $narrative->addArchive(
                $name,
                $narrativeBundle,
                Category::first()->CategoryID,
                true,
                Topic::first()->TopicID
            );

        $extractedPath = Config::get('media.paths.extracted') 
                . DIRECTORY_SEPARATOR
                . $name;

        $this->assertCount(1, Narrative::all());

        File::deleteDirectory($extractedPath);
    }

    /**
     * Checks to ensure that the images are process properly.
     *
     * @covers Narrative::addArchive
     * @covers Narrative::extractArchive
     * @covers Narrative::findNarratives
     * @covers Narrative::processNarrative
     * @covers Narrative::createFromXML
     * @covers Narrative::processMedia
     * @covers Narrative::processImageMedia
     * @covers Narrative::processAudioMedia
     */
    public function testProcessImageMedia()
    {
        // This should refer to the narrative bundle for unit testing.
        $narrativeBundle = Config::get('media.paths.uploads')
            . DIRECTORY_SEPARATOR
            . 'unit_testing_narrative_bundle.zip';

        $this->assertTrue(File::exists($narrativeBundle), 'The narrative bundle for unit testing is missing.');

        $name = time();

        // Mock the audio transcoding so that we don't spend any time
        // waiting for things to transcode.
        Queue::shouldReceive('push')->times(8)->andReturn(true);

        $narrative = new Narrative;
        $narrative->addArchive(
                $name,
                $narrativeBundle,
                Category::first()->CategoryID,
                true,
                Topic::first()->TopicID
            );

        $extractedPath = Config::get('media.paths.extracted') 
                . DIRECTORY_SEPARATOR
                . $name;

        $processedPath = Config::get('media.paths.processed')
                . DIRECTORY_SEPARATOR
                . Narrative::first()->NarrativeID;

        $this->assertFileExists($processedPath);

        $files = File::files($processedPath);

        $this->assertCount(5, $files);

        File::deleteDirectory($extractedPath);
    }

    /**
     * @covers Narrative::toResponseArray
     */
    public function testToResponseArray()
    {
        $this->addNarrativeToDatabase();

        $narrative = Narrative::first();

        $array = $narrative->toResponseArray();

        $this->assertEquals($narrative->NarrativeID, $array['id']);
        $this->assertEquals($narrative->Name, $array['name']);

        $this->assertCount(
            $narrative->media()->images()->get()->count(),
            $array['images']
        );

        $this->assertCount(
            $narrative->media()->audio()->get()->count(),
            $array['audio']
        );
    }

}
