<?php

class CommentDbTest extends TestCase
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
     * Ensure comment get fetched.
     */
    public function testCommentRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }

     /**
     * Ensure comment get created (for a Narrative).
     */
    public function testCommentCreationNarrative()
    {
        $commentCreated = new Comment;

        $commentCreated->NarrativeID = 1;
        $commentCreated->CommentParentID = NULL;
        $commentCreated->Name = "Test";
        $commentCreated->Agrees = 0;
        $commentCreated->Indifferents = 1;
        $commentCreated->Disagrees = 1;
        $commentCreated->Comment = "Test";

        $commentCreated->save();

        $insertedId = $commentCreated->CommentId;

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

        $commentFetched = Comment::find($insertedId);

        $this->assertNull($commentFetched);
    }
    /**
     * Ensure comment get created (for a Comment).
     */
    public function testCommentCreationComment($id)
    {
        $commentCreated = new Comment;

        $commentCreated->NarrativeID = 1;
        $commentCreated->CommentParentID = $id;
        $commentCreated->Name = "Test";
        $commentCreated->Agrees = 0;
        $commentCreated->Indifferents = 1;
        $commentCreated->Disagrees = 1;
        $commentCreated->Comment = "Test";

        $commentCreated->save();

        $insertedId = $commentCreated->CommentId;

        $commentFetched = Comment::find($insertedId);

        $this->assertEquals(1, $commentFetched->NarrativeID);
        $this->assertEquals($id, $commentFetched->CommentParentID);
        $this->assertEquals("Test", $commentFetched->Name);
        $this->assertEquals(0, $commentFetched->Agrees);
        $this->assertEquals(1, $commentFetched->Indifferents);
        $this->assertEquals(1, $commentFetched->Disagrees);
        $this->assertEquals("Test", $commentFetched->Comment);

        $commentFetched->delete();

        $commentFetched = Comment::find($insertedId);

        $this->assertNull($commentFetched);

    }

}
