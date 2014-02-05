<?php

class CommentControllerTest extends TestCase
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
     * Ensure comment get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testCommentRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }

     /**
     * Ensure comment get created (for a Narrative).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testCommentCreationNarrative()
    {
        $commentCreated = new Comment;

        $commentCreated->NarrativeID = 1;
        $commentCreated->CommentParentID = NULL;
        $commentCreated->Name = "Test";
        //agrees will be check for default value
        $commentCreated->Indifferents = 1;
        $commentCreated->Disagrees = 1;
        $commentCreated->Comment = "Test";

        $commentCreated->save();

        $insertedId = $commentCreated->id;

        $commentFetched = Comment::find($insertedId);

        $this->assertEquals(1, $commentFetched->NarrativeID);
        $this->assertEquals(NULL, $commentFetched->CommentParentID);
        $this->assertEquals("Test", $commentFetched->Name);
        $this->assertEquals(0, $commentFetched->Agrees);
        $this->assertEquals(1, $commentFetched->Indifferents);
        $this->assertEquals(1, $commentFetched->Disagrees);
        $this->assertEquals("Test", $commentFetched->Comment);

        testCommentCreationComment($insertedId);//Make this comment the parent of the next test case

        $commentFetched->delete();
    }
    /**
     * Ensure comment get created (for a Comment).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testCommentCreationComment(int $id)
    {
        $commentCreated = new Comment;

        $commentCreated->NarrativeID = 1;
        $commentCreated->CommentParentID = $id;
        $commentCreated->Name = "Test";
        //agrees will be check for default value
        $commentCreated->Indifferents = 1;
        $commentCreated->Disagrees = 1;
        $commentCreated->Comment = "Test";

        $commentCreated->save();

        $insertedId = $commentCreated->id;

        $commentFetched = Comment::find($insertedId);

        $this->assertEquals(1, $commentFetched->NarrativeID);
        $this->assertEquals($id, $commentFetched->CommentParentID);
        $this->assertEquals("Test", $commentFetched->Name);
        $this->assertEquals(0, $commentFetched->Agrees);
        $this->assertEquals(1, $commentFetched->Indifferents);
        $this->assertEquals(1, $commentFetched->Disagrees);
        $this->assertEquals("Test", $commentFetched->Comment);

        $commentFetched->delete();

    }

}
