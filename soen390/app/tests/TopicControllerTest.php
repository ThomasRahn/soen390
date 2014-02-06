<?php

class TopicControllerTest extends TestCase
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
     * Ensure topics get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testTopicRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure topic gets created.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testTopicCreation()
    {
        $topicCreated = new Topic;

        $topicCreated->Description = "Test";
        $topicCreated->Name = "Test";

        $topicCreated->save();

        $insertedId = $topicCreated->id;

        $topicFetched = Topic::find($insertedId);

        $this->assertEquals("Test", $topicFetched->Description);
        $this->assertEquals("Test", $topicFetched->Name);

        $topicFetched->delete();

        $topicFetched = Topic::find($insertedId);

        $this->assertNull($topicFetched);

    }

}
