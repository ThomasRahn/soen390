<?php

class FlagTest extends TestCase
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
     * Ensure flags get fetched.
     *
     */
    public function testFlagRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
     /**
     * Ensure flags get created (for a Narrative).
     * @covers Flag::save
     * @covers Flag::create
     * @covers Flag::delete
     */
    public function testFlagCreationNarrative()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = 1;
        $flagCreated->CommentID = NULL;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $insertedId = $flagCreated->FlagID;

        $flagFetched = Flag::find($insertedId);

        $this->assertEquals(1, $flagFetched->NarrativeID);
        $this->assertEquals(NULL, $flagFetched->CommentID);
        $this->assertEquals("Test", $flagFetched->Comment);

        $flagFetched->delete();

        $flagFetched = Flag::find($insertedId);

        $this->assertNull($flagFetched);

    }
    /**
     * Ensure flags get created (for a Comment).
     *
     */
    public function testFlagCreationComment()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = NULL;
        $flagCreated->CommentID = 1;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $insertedId = $flagCreated->FlagID;

        $flagFetched = Flag::find($insertedId);

        $this->assertEquals(NULL, $flagFetched->NarrativeID);
        $this->assertEquals(1, $flagFetched->CommentID);
        $this->assertEquals("Test", $flagFetched->Comment);

        $flagFetched->delete();

        $flagFetched = Flag::find($insertedId);

        $this->assertNull($flagFetched);

    }
     /**
     * Testing relationship from flag to narrative
     * @covers Flag::narrative
     */
    public function testFlagNarrativeRelationship()
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

        $flagCreated = new Flag;

        $flagCreated->NarrativeID = 1;
        $flagCreated->CommentID = NULL;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $narrative = Flag::find(1)->narrative();
        $this->assertNotNull($narrative);

    }
      /**
     * Testing relationship from flag to comment
     * @covers Flag::comment
     */
    public function testFlagCommentRelationship()
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
        
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = NULL;
        $flagCreated->CommentID = 1;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $comment = Flag::find(1)->comment();
        $this->assertNotNull($comment);

    }
}
