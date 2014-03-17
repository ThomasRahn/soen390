<?php

class AdminCommentControllerTest extends TestCase
{

    /**
     * Check for proper view and response code.
     *
     * @covers AdminCommentController::destroy
     */
    public function testDestroy()
    {
        // Set the user
        $user = new User(array('email' => 'user@domain.local'));
        $this->be($user);

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


        $response = $this->call('DELETE', 'admin/narrative/comment/1');

        $this->assertNull(Comment::find(1));
    }
}
