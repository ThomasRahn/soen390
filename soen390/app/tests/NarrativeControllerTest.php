<?php

class NarrativeControllerTest extends TestCase
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
     * Attempt to display an non-existant narrative. This should result in a
     * NotFoundHttpException.
     *
     * @covers            NarrativeController::show
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testShowWithInvalidNarrative()
    {
        $response = $this->action('GET', 'NarrativeController@show', array('id' => 10));

        $this->assertResponseStatus(404);
    }

    /**
     * Display an existing narrative.
     *
     * @covers NarrativeController::show
     */
    public function testShowWithValidNarrative()
    {
        $this->addNarrativeToDatabase();

        $narrative = Narrative::first();

        $response = $this->action('GET', 'NarrativeController@show', array('id' => $narrative->NarrativeID));

        $this->assertResponseOk();

        $view = $response->original;

        $this->assertEquals('narrative', $view->getName());
    }

}
