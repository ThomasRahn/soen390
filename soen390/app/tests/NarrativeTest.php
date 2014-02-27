<?php

class NarrativeTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     * @covers ApiNarrativeController::index
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
     *  @covers Narrative::create
     *  @covers Narrative::save
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
    /*
    *   Testing the relationship between narative and category
    *
    *  @covers Narrative::category
    */
    public function testNarrativeCategory(){
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

        $category = new Category;
        $category->CategoryID = 1;
        $category->Description = "hello";
        $category->save();

        $category1 = Narrative::find(1)->category()->first();
        $this->assertNotNull($category1);

    }
      /*
    *   Testing the relationship between narative and Language
    *
    *  @covers Narrative::language
    */
    public function testNarrativeLanguage(){
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

        $language = new Language;
        $language->LanguageID = 1;
        $language->Description = "hello";
        $language->save();

        $langauge1 = Narrative::find(1)->language()->first();
        $this->assertNotNull($langauge1);

    }
  /*
    *   Testing the relationship between narative and Media Item
    *
    *  @covers Narrative::media
    */
    public function testNarrativeMedia(){
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

        $media = new Media;
        $media->id = 1;
        $media->filename = "hello";
        $media->basename = "hello";
        $media->type = "hello";
        $media->save();

        $media1 = Narrative::find(1)->media();
        $this->assertNotNull($media1);

    }
}
