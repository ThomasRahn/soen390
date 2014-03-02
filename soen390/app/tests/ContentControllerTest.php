<?php

class ContentControllerTest extends TestCase
{

    /**
     * Clean up after the test run.
     */
    public function tearDown()
    {
        Mockery::close();

        // Delete each processed narrative directory.
        foreach (Narrative::all() as $n) {
            $path = Config::get('media.paths.processed')
                    . DIRECTORY_SEPARATOR
                    . $n->NarrativeID;

            File::deleteDirectory($path);
        }

        // Delete each extracted directory.

        $extractedDirectories = File::directories(
                Config::get('media.paths.extracted')
            );

        foreach ($extractedDirectories as $path)
            File::deleteDirectory($path);
    }

    /**
     * Adds a single narrative to the database.
     */
    protected function addNarrativeToDatabase($published = true)
    {
        // This should refer to the narrative bundle for unit testing.
        $narrativeBundle = Config::get('media.paths.uploads')
            . DIRECTORY_SEPARATOR
            . 'unit_testing_narrative_bundle.zip';

        $this->assertTrue(File::exists($narrativeBundle), 'The narrative bundle for unit testing is missing.');

        // Seed the required tables first.
        $this->seed('CategoryTableSeeder');
        $this->seed('TopicTableSeeder');
        $this->seed('LanguageTableSeeder');

        $name = time();

        // Mock the audio transcoding so that we don't spend any time
        // waiting for things to transcode.
        Queue::shouldReceive('connected')->with('iron')->andReturn(false);
        Queue::shouldReceive('push')->times(8)->andReturn(true);

        Narrative::addArchive(
                $name,
                $narrativeBundle,
                Category::first()->CategoryID,
                $published
            );
    }

    /**
     * Attempt to get a media file that doesn't exist.
     *
     * @covers            ContentController::getContent
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetNonExistentContent()
    {
        $response = $this->action('GET', 'ContentController@getContent', array('id' => 10));

        $this->assertResponseStatus(404);
    }

    /**
     * Attempt to get an existant media file.
     *
     * @covers ContentController::getContent
     */
    public function testGetExistingContent()
    {
        $this->addNarrativeToDatabase(true);

        $media = Narrative::first()->media()->images()->first();

        $response = $this->action('GET', 'ContentController@getContent', array('id' => $media->id));

        $this->assertResponseOk();
    }

}
