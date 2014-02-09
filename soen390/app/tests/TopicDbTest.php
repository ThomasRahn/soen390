<?php

class TopicDbTest extends TestCase
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
     * Ensure Topics get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testTopicRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure Topic gets created.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testCategoryCreation()
    {
        $topicCreated = new Topic;

        $date = date_create_from_format('j-M-Y', '1-Jan-2000');

        $topicCreated->Description = "Test";
        $topicCreated->DateCreated = $date;
        $topicCreated->DateModified = $date;
        $topicCreated->Name = "Test";

        $topicCreated->save();

        $insertedId = $topicCreated->TopicID;

        $topicFetched = Topic::find($insertedId);

        $this->assertEquals("Test", $topicFetched->Description);
        $this->assertEquals("Test", $topicFetched->Name);

        $topicFetched->delete();

        $topicFetched = Topic::find($insertedId);

        $this->assertNull($topicFetched);

    }

}
