<?php

class LanguageControllerTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testIndex()
    {
        /*$response = $this->call('GET', 'api/topic');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());*/
    }
    /**
     * Ensure Languages get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testTopicRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure Languages gets created.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testLanguageCreation()
    {
        $languageCreated = new Language;

        $languageCreated->Description = "Test";

        $languageCreated->save();

        $insertedId = $languageCreated->id;

        $languageFetched = Language::find($insertedId);

        $this->assertEquals("Test", $languageFetched->Description);

        $languageFetched->delete();

    }

}
