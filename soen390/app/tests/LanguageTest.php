<?php

class LanguageTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
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
     */
    public function testTopicRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure Languages gets created.
     *
     */
    public function testLanguageCreation()
    {
        $languageCreated = new Language;

        $languageCreated->Description = "Test";

        $languageCreated->save();

        $insertedId = $languageCreated->LanguageID;

        $languageFetched = Language::find($insertedId);

        $this->assertEquals("Test", $languageFetched->Description);

        $languageFetched->delete();

        $languageFetched = Language::find($insertedId);

        $this->assertNull($languageFetched);

    }
      /**
     * Ensure Category gets created.
     * @covers Category::narratives
     */
    public function testLanguageNarrativesRelation()
    {
        $languageCreated = new Language;
        $languageCreated->LanguageID = 1;
        $languageCreated->Description = "Test";

        $languageCreated->save();

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

        $narratives = Language::find(1)->narrative();
        $this->assertTrue($narratives->count() > 0);

        

    }
}
