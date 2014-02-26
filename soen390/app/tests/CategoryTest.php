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

}
