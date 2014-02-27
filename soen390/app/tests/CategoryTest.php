<?php

class CategoryTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     */
    public function testIndex()
    {
        /*$response = $this->call('GET', 'api/topic');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());*/
    }
    /**
     * Ensure Categories get fetched.
     */
    public function testTopicRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure Category gets created.
     * @covers Category::save
     * @covers Category::create
     * @covers Category::delete
     */
    public function testCategoryCreation()
    {
        $categoryCreated = new Category;

        $categoryCreated->Description = "Test";

        $categoryCreated->save();

        $insertedId = $categoryCreated->CategoryID;

        $categoryFetched = Category::find($insertedId);

        $this->assertEquals("Test", $categoryFetched->Description);

        $categoryFetched->delete();

        $categoryFetched = Category::find($insertedId);

        $this->assertNull($categoryFetched);

    }
   /**
     * Ensure Category gets created.
     * @covers Category::narratives
     */
    public function testCategoryNarrativesRelation()
    {
        $categoryCreated = new Category;
        $categoryCreated->CategoryID = 1;
        $categoryCreated->Description = "Test";

        $categoryCreated->save();

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

        $narratives = Category::find(1)->narrative();
        $this->assertTrue($narratives->count() > 0);

        

    }

}
