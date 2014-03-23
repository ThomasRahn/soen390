<?php

class CommentTest extends TestCase
{

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
     /**
     *  Test relationship between Comment and narrative
     *
     * @covers Comment::flags
     */
    public function testCommentFlagRelationship()
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
        $flagCreated = Flag::create(array('CommentID'=>1, 'Comment'=>'Terrible'));

        $flag = Comment::find(1)->flags();

        $this->assertNotNull($flag);
    }

    /**
     * Test the relationship between a Comment and its associate child
     * comments.
     *
     * @covers Comment::comments
     * @uses   Eloquent
     */
    public function testCommentToCommentRelationship()
    {
        $this->addNarrativeToDatabase();

        $narrative = Narrative::first();

        $parentComment = Comment::create(array(
            'NarrativeID' => $narrative->NarrativeID,
            'Name'        => 'Unit Test User',
            'Comment'     => 'Unit Test Comment',
            'DateCreated' => Carbon\Carbon::now(),
        ));

        $childComments = array();

        $childComments[] = Comment::create(array(
            'NarrativeID' => $narrative->NarrativeID,
            'CommentParentID' => $parentComment->CommentID,
            'Name'            => 'Unit Test User 2',
            'Comment'         => 'Unit Test Comment 2',
            'DateCreated'     => Carbon\Carbon::now(),
        ));

        $childComments[] = Comment::create(array(
            'NarrativeID' => $narrative->NarrativeID,
            'CommentParentID' => $parentComment->CommentID,
            'Name'            => 'Unit Test User 3',
            'Comment'         => 'Unit Test Comment 3',
            'DateCreated'     => Carbon\Carbon::now(),
        ));

        $narrativeComment = $narrative->comments()->first();

        $commentChilds = $narrativeComment->comments()->get();

        $this->assertCount(count($childComments), $commentChilds);
    }

    
}
