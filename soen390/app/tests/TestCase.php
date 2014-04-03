<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    protected $narrativeArchivePath = '';

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }

    public function setUp()
    {
        parent::setUp();
        $this->prepareForTests();
    }

    private function prepareForTests()
    {
        Artisan::call('migrate');
        Mail::pretend(true);

        $this->narrativeArchivePath = Config::get('media.paths.uploads')
            . DIRECTORY_SEPARATOR . 'unit_testing_narrative_bundle.zip';

        $this->seed('LanguageTableSeeder');
        $this->seed('CategoryTableSeeder');
        $this->seed('TopicTableSeeder');
    }

    public function tearDown()
    {
        parent::tearDown();

        // Empty out the media extracted and processed directories.
        $directoriesForDeletion = array();
        $directoriesForDeletion += File::directories(Config::get('media.paths.processed'));
        $directoriesForDeletion += File::directories(Config::get('media.paths.extracted'));

        foreach ($directoriesForDeletion as $d)
        	File::deleteDirectory($d);
    }

    protected function addNarrativeToDatabase($published = true)
    {
        $this->assertTrue(File::exists($this->narrativeArchivePath), 'The narrative bundle for unit testing is missing.');

        $name = time();

        // We need to mock Sonus
        $sonus = Mockery::mock('Rafasamp\Sonus\Sonus');
        $sonus->shouldReceive('getMediaInfo')->andReturn(array(
                'format' => array(
                    'duration' => '00:00:10.500000',
                ),
            ));

        App::instance('Sonus', $sonus);

        $narrative = new Narrative;
        $narrative->addArchive(
                $name,
                $this->narrativeArchivePath,
                Category::first()->CategoryID,
                $published,
                Topic::first()->TopicID
            );
    }

}
