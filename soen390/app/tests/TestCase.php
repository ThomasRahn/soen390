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
    }

    public function tearDown()
    {
        parent::tearDown();

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

    protected function addNarrativeToDatabase($published = true)
    {
        $this->assertTrue(File::exists($this->narrativeArchivePath), 'The narrative bundle for unit testing is missing.');

        // Seed the required tables first.
        $this->seed('CategoryTableSeeder');
        $this->seed('TopicTableSeeder');
        $this->seed('LanguageTableSeeder');

        $name = time();

        // We need to mock Sonus
        $sonus = Mockery::mock('Rafasamp\Sonus\Sonus');
        $sonus->shouldReceive('getMediaInfo')->andReturn(array(
                'format' => array(
                    'duration' => '00:00:10.500000',
                ),
            ));

        App::instance('Sonus', $sonus);

        (new Narrative)->addArchive(
                $name,
                $this->narrativeArchivePath,
                Category::first()->CategoryID,
                $published
            );
    }

}
