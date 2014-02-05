<?php

class ContentControllerTest extends TestCase
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
     * Ensure content get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testContentRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }

     /**
     * Ensure content get created (for a Narrative).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testContentCreationNarrative()
    {
        $contentCreated = new Content;

        $contentCreated->NarrativeID = 1;
        $contentCreated->CategoryID = NULL;
        $contentCreated->CommentID = NULL;
        $contentCreated->AudioPath = "Test";
        $contentCreated->PicturePath = "Test";

        $contentCreated->save();

        $insertedId = $contentCreated->id;

        $contentFetched = Content::find($insertedId);

        $this->assertEquals(1, $contentFetched->NarrativeID);
        $this->assertEquals(NULL, $contentFetched->CategoryID);
        $this->assertEquals(NULL, $contentFetched->CommentID);
        $this->assertEquals("Test", $contentFetched->AudioPath);
        $this->assertEquals("Test", $contentFetched->PicturePath);

        $contentFetched->delete();
    }
    /**
     * Ensure content get created (for a Comment).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testContentCreationComment(int $id)
    {
        $contentCreated = new Content;

        $contentCreated->NarrativeID = NULL;
        $contentCreated->CategoryID = 1;
        $contentCreated->CommentID = NULL;
        $contentCreated->AudioPath = "Test";
        $contentCreated->PicturePath = NULL;

        $contentCreated->save();

        $insertedId = $contentCreated->id;

        $contentFetched = Content::find($insertedId);

        $this->assertEquals(NULL, $contentFetched->NarrativeID);
        $this->assertEquals(1, $contentFetched->CategoryID);
        $this->assertEquals(NULL, $contentFetched->CommentID);
        $this->assertEquals("Test", $contentFetched->AudioPath);
        $this->assertEquals(NULL, $contentFetched->PicturePath);

        $contentFetched->delete();

    }
    /**
     * Ensure content get created (for a Topic).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testContentCreationTopic(int $id)
    {
        $contentCreated = new Content;

        $contentCreated->NarrativeID = NULL;
        $contentCreated->CategoryID = NULL;
        $contentCreated->CommentID = 1;
        $contentCreated->AudioPath = NULL;
        $contentCreated->PicturePath = "Test";

        $contentCreated->save();

        $insertedId = $contentCreated->id;

        $contentFetched = Content::find($insertedId);

        $this->assertEquals(NULL, $contentFetched->NarrativeID);
        $this->assertEquals(NULL, $contentFetched->CategoryID);
        $this->assertEquals(1, $contentFetched->CommentID);
        $this->assertEquals(NULL, $contentFetched->AudioPath);
        $this->assertEquals("Test", $contentFetched->PicturePath);

        $contentFetched->delete();

    }


}
