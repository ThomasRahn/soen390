<?php

class ApiFlagControllerTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiFlagController::index
     */
    public function testIndex()
    {
        $response = $this->call('GET', 'api/flags');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

     /**
     * Test the API's index and ensures that response is valid JSON and has flags.
     *
     * @covers ApiFlagController::index
     */
    public function testIndexWithFlags()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = 1;
        $flagCreated->CommentID = NULL;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

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

        $response = $this->call('GET', 'api/flags');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

}
