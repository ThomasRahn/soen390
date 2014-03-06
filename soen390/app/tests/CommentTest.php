<?php

class CommentTest extends TestCase
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
     *
     * @covers Comment::save
     * @covers Comment::create
     * @covers Comment::delete
     */
    public function testCommentCreationNarrative()
    {
        $commentCreated = Comment::create(array('NarrativeID'=>1,'Name'=>'test','Agrees'=>0,'Indifferents'=>1,'Disagrees'=>1,'DateCreated'=>date('Y-m-d H:i:s'), 'Comment'=>'TEST'));

        $insertedId = $commentCreated->CommentID;

        $commentFetched = Comment::find($insertedId);

        $this->assertEquals(1, $commentFetched->NarrativeID);
        $this->assertEquals(NULL, $commentFetched->CommentParentID);
        $this->assertEquals("test", $commentFetched->Name);
        $this->assertEquals(0, $commentFetched->Agrees);
        $this->assertEquals(1, $commentFetched->Indifferents);
        $this->assertEquals(1, $commentFetched->Disagrees);
        $this->assertEquals("TEST", $commentFetched->Comment);

        $commentFetched->delete();

        $commentFetched = Comment::find($insertedId);

        $this->assertNull($commentFetched);
    }
     /**
     *  Test relationship between Comment and narrative
     *
     * @covers Comment::Narrative
     */
    public function testCommentNarrativeRelationship()
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

        $commentCreated = Comment::create(array('NarrativeID'=>1,'Name'=>'test','Agrees'=>0,'Indifferents'=>1,'Disagrees'=>1,'DateCreated'=>date('Y-m-d H:i:s'), 'Comment'=>'TEST'));
        $narrative = Comment::find(1)->narrative();

        $this->assertNotNull($narrative);
       
    }

    
}
