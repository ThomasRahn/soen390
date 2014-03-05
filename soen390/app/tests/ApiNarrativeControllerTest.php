<?php

class ApiNarrativeControllerTest extends TestCase
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

        // We need to mock Sonus
        $sonus = Mockery::mock('Rafasamp\Sonus\Sonus');
        $sonus->shouldReceive('getMediaInfo')->andReturn(array(
                'format' => array(
                    'duration' => '00:00:10.500000',
                ),
            ));

        Narrative::addArchive(
                $name,
                $narrativeBundle,
                Category::first()->CategoryID,
                $published
            );
    }

    /**
     * Test the index action and ensure that, with an empty database,
     * we get a result with length of 0.
     *
     * @covers ApiNarrativeController::index
     * @covers ApiNarrativeController::narrativeToArray
     */
    public function testIndexWithEmptyDatabase()
    {
        $response = $this->action('GET', 'ApiNarrativeController@index');

        $this->assertResponseOk();
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent());

        $this->assertCount(0, $json->return);
    }

    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiNarrativeController::index
     * @covers ApiNarrativeController::narrativeToArray
     */
    public function testIndexWithPopulatedDatabase()
    {
        $this->addNarrativeToDatabase();

        $this->be(new User(array('email' => 'admin@user.local')));

        $response = $this->action('GET', 'ApiNarrativeController@index');

        $this->assertResponseOk();
        $this->assertJson($response->getContent());

        $json = json_decode($response->getContent());

        $this->assertCount(1, $json->return);
    }

    /**
     * Test the index action and list all narratives to ensure that guests
     * can't see unpublished narratives.
     *
     * @covers ApiNarrativeController::index
     * @covers ApiNarrativeController::narrativeToArray
     */
    public function testIndexForUnpublishedFromGuest()
    {
        $this->addNarrativeToDatabase(false);

        $response = $this->action('GET', 'ApiNarrativeController@index', array('withUnpublished' => 1));

        $json = json_decode($response->getContent());

        $this->assertCount(0, $json->return);
    }

    /**
     * Test the index action and list all narratives to ensure that admins
     * can see unpublished narratives.
     *
     * @covers ApiNarrativeController::index
     * @covers ApiNarrativeController::narrativeToArray
     */
    public function testIndexForUnpublishedFromAdmin()
    {
        $this->addNarrativeToDatabase(false);

        $this->be(new User(array('email' => 'admin@user.local')));

        $response = $this->action('GET', 'ApiNarrativeController@index', array('withUnpublished' => 1));

        $json = json_decode($response->getContent());

        $this->assertCount(1, $json->return);
    }


    /**
     * Test the show action by requesting a non-existent narrative.
     *
     * @covers ApiNarrativeController::show
     */
    public function testShowWithInvalidNarrative()
    {
        $this->addNarrativeToDatabase(true);

        $response = $this->action('GET', 'ApiNarrativeController@show', array('id' => 100, 'withUnpublished' => 1));

        $this->assertResponseStatus(404);
    }

    /**
     * Test the show action by requesting an existing narrative.
     *
     * @covers ApiNarrativeController::show
     * @covers ApiNarrativeController::narrativeToArray
     * @covers TranscodeAudio::fire
     * @covers TranscodeAudio::createMediaInstance
     */
    public function testShowWithValidNarrative()
    {
        $this->addNarrativeToDatabase(true);

        $narrative = Narrative::first();

        $response = $this->action('GET', 'ApiNarrativeController@show', array('id' => $narrative->NarrativeID, 'withUnpublished' => 1));

        $content = $response->getContent();

        $this->assertJson($content);

        $jsonContent = json_decode($content);

        $resJson = $jsonContent->return;

        $this->assertEquals($narrative->NarrativeID,                      $resJson->id);
        $this->assertEquals($narrative->Name,                             $resJson->name);
        $this->assertEquals($narrative->category()->first()->Description, $resJson->stance);
        $this->assertEquals($narrative->language()->first()->Description, $resJson->lang);
        $this->assertEquals($narrative->Views,                            $resJson->views - 1);
        $this->assertEquals($narrative->Agrees,                           $resJson->yays);
        $this->assertEquals($narrative->Disagrees,                        $resJson->nays);
        $this->assertEquals($narrative->Indifferents,                     $resJson->mehs);
        $this->assertEquals($narrative->DateCreated,                      $resJson->createdAt);
        $this->assertEquals($narrative->Published,                        $resJson->published);

        $this->assertCount(5, $resJson->images);
        $this->assertCount(8, $resJson->audio);
    }

    /**
     * Test the show action by requesting an unpublished narrative as a guest
     * user.
     *
     * @covers ApiNarrativeController::show
     */
    public function testShowForUnpublishedNarrativeFromGuest()
    {
        $this->addNarrativeToDatabase(false);

        $narrative = Narrative::first();

        $response = $this->action('GET', 'ApiNarrativeController@show', array('id' => $narrative->NarrativeID, 'withUnpublished' => 1));

        $this->assertResponseStatus(404);
    }

    /**
     * Test the show action by requesting an unpublished narrative as an admin
     * user.
     *
     * @covers ApiNarrativeController::show
     * @covers ApiNarrativeController::narrativeToArray
     */
    public function testShowForUnpublishedNarrativeFromAdmin()
    {
        $this->be(new User(array('email' => 'admin@user.local')));

        $this->addNarrativeToDatabase(false);

        $narrative = Narrative::first();

        $response = $this->action('GET', 'ApiNarrativeController@show', array('id' => $narrative->NarrativeID, 'withUnpublished' => 1));

        $content = $response->getContent();

        $this->assertJson($content);

        $jsonContent = json_decode($content);

        $resJson = $jsonContent->return;

        $this->assertEquals($narrative->NarrativeID,                      $resJson->id);
        $this->assertEquals($narrative->Name,                             $resJson->name);
        $this->assertEquals($narrative->category()->first()->Description, $resJson->stance);
        $this->assertEquals($narrative->language()->first()->Description, $resJson->lang);
        $this->assertEquals($narrative->Views,                            $resJson->views - 1);
        $this->assertEquals($narrative->Agrees,                           $resJson->yays);
        $this->assertEquals($narrative->Disagrees,                        $resJson->nays);
        $this->assertEquals($narrative->Indifferents,                     $resJson->mehs);
        $this->assertEquals($narrative->DateCreated,                      $resJson->createdAt);
        $this->assertEquals($narrative->Published,                        $resJson->published);
    }

    /**
     * Test the update action by attempting to modify a non-existent narrative.
     *
     * @covers ApiNarrativeController::update
     */
    public function testUpdateWithInvalidNarrative()
    {
        $this->addNarrativeToDatabase(true);

        $narrative = Narrative::count() + 1;

        Validator::shouldReceive('fails')->andReturn(false);

        $response = $this->action('PUT', 'ApiNarrativeController@update', array('id' => $narrative));

        $this->assertResponseStatus(404);
    }

    /**
     * Test the update action with an existing narrative.
     *
     * @covers ApiNarrativeController::update
     * @covers ApiNarrativeController::narrativeToArray
     */
    public function testUpdateWithValidNarrative()
    {
        $this->addNarrativeToDatabase(true);

        $narrative = Narrative::first();

        $validator = Mockery::mock('Illuminate\Validation\Factory');

        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(false);

        Validator::swap($validator);

        $response = $this->action('PUT', 'ApiNarrativeController@update', array('id' => $narrative->NarrativeID));

        $content = $response->getContent();

        $this->assertJson($content);

        $jsonContent = json_decode($content);

        $resJson = $jsonContent->return;

        $this->assertEquals($narrative->NarrativeID,                      $resJson->id);
        $this->assertEquals($narrative->Name,                             $resJson->name);
        $this->assertEquals($narrative->category()->first()->Description, $resJson->stance);
        $this->assertEquals($narrative->language()->first()->Description, $resJson->lang);
        $this->assertEquals($narrative->Views,                            $resJson->views);
        $this->assertEquals($narrative->Agrees,                           $resJson->yays);
        $this->assertEquals($narrative->Disagrees,                        $resJson->nays);
        $this->assertEquals($narrative->Indifferents,                     $resJson->mehs);
        $this->assertEquals($narrative->DateCreated,                      $resJson->createdAt);
        $this->assertEquals($narrative->Published,                        $resJson->published);
    }

    /**
     * Test the update action when we have an existing narrative, but the
     * input validation fails.
     *
     * @covers ApiNarrativeController::update
     */
    public function testUpdateWithValidNarrativeButInvalidInput()
    {
        $this->addNarrativeToDatabase(true);

        $narrative = Narrative::first();

        $validator = Mockery::mock('Illuminate\Validation\Factory');

        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(true);
        $validator->shouldReceive('errors')->once()->andReturn(new Illuminate\Support\MessageBag);

        Validator::swap($validator);

        $response = $this->action('PUT', 'ApiNarrativeController@update', array('id' => $narrative->NarrativeID));

        $this->assertResponseStatus(400);
    }

}
