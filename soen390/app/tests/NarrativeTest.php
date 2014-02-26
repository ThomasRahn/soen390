<?php

class NarrativeTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     */
    public function testIndex()
    {
        $response = $this->call('GET', 'api/narrative');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }
    /**
     * Ensure narratives get fetched.
     *
     */
    public function testNarrativeRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure narratives get created.
     *
     */
    public function testNarrativeCreation()
    {
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

        $insertedId = $narrativeCreated->NarrativeID;

        $narrativeFetched = Narrative::find($insertedId);

        $this->assertEquals(1, $narrativeFetched->TopicID);
        $this->assertEquals(1, $narrativeFetched->CategoryID);
        $this->assertEquals(1, $narrativeFetched->LanguageID);
        $this->assertEquals("Test", $narrativeFetched->Name);
        $this->assertEquals(1, $narrativeFetched->Agrees);
        $this->assertEquals(1, $narrativeFetched->Disagrees);
        $this->assertEquals(1, $narrativeFetched->Indifferents);
        $this->assertEquals(0, $narrativeFetched->Views);//Test for default value
        $this->assertEquals(1,$narrativeFetched->Published);
        $narrativeFetched->delete();

        $narrativeFetched = Narrative::find($insertedId);

        $this->assertNull($narrativeFetched);

    }

}
