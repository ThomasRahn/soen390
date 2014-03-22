<?php

use Carbon\Carbon;

class ApiCommentControllerTest extends TestCase
{

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * Test the getNarrative action with an invalid ID. The controller should
     * return with a 404 status.
     *
     * @covers ApiCommentController::getNarrative
     */
    public function testGetNarrativeWithInvalidId()
    {
        $response = $this->action(
            'GET',
            'ApiCommentController@getNarrative',
            array('id' => 70)
        );

        $this->assertResponseStatus(404);
        $this->assertJson($response->getContent());
        $this->assertFalse(json_decode($response->getContent())->success);
    }

    /**
     * Test the getNarrative action with a valid ID. The controller should
     * return with status 200 and no comments.
     *
     * @covers ApiCommentController::getNarrative
     */
    public function testGetNarrativeWithValidId()
    {
        $this->addNarrativeToDatabase();

        $id = Narrative::first()->NarrativeID;

        $response = $this->action(
            'GET',
            'ApiCommentController@getNarrative',
            array('id' => $id)
        );

        $this->assertResponseOk();
        $this->assertJson($response->getContent());
        $this->assertTrue(json_decode($response->getContent())->success);
        $this->assertEmpty(json_decode($response->getContent())->return);
    }

    /**
     * Test the getNarrative action with a valid narrative containing a
     * single comment.
     *
     * @covers ApiCommentController::getNarrative
     * @covers ApiCommentController::convertCommentToArray
     */
    public function testGetNarrativeWithSingleComment()
    {
        $this->addNarrativeToDatabase();

        $id = Narrative::first()->NarrativeID;

        $c = Comment::create(array(
            'NarrativeID' => $id,
            'DateCreated' => new DateTime,
            'Name'        => 'Test User',
            'Comment'     => 'testGetNarrativeWithSingleComment',
        ));

        $response = $this->action(
            'GET',
            'ApiCommentController@getNarrative',
            array('id' => $id)
        );

        $this->assertResponseOk();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertCount(1, $data->return);

        $data = $data->return[0];

        $expectedDateString = Carbon::instance($c->DateCreated);
        $expectedDateString = $expectedDateString->diffForHumans();

        $this->assertEquals(1, $data->comment_id);
        $this->assertEquals($c->NarrativeID, $data->narrative_id);
        $this->assertNull($data->parent_id);
        $this->assertEquals(
            $expectedDateString,
            $data->created_at
        );
        $this->assertNull($data->deleted_at);
        $this->assertEquals($c->Name, $data->name);
        $this->assertEquals(0, $data->agrees);
        $this->assertEquals(0, $data->disagrees);
        $this->assertEquals(0, $data->indifferents);
        $this->assertEquals($c->Comment, $data->body);
    }

    /**
     * Test the getNarrative action with a single comment and multiple child
     * comments under it.
     *
     * @covers ApiCommentController::getNarrative
     * @covers ApiCommentController::convertCommentToArray
     * @uses   Narrative
     * @uses   Comment
     */
    public function testGetNarrativeWithChildComments()
    {
        $this->addNarrativeToDatabase();

        $id = Narrative::first()->NarrativeID;

        $c = Comment::create(array(
            'NarrativeID' => $id,
            'DateCreated' => new DateTime,
            'Name'        => 'Test User',
            'Comment'     => 'testGetNarrativeWithSingleComment',
        ));

        $childComments = array();

        $childComments[] = Comment::create(array(
            'NarrativeID'     => $id,
            'CommentParentID' => $c->CommentID,
            'DateCreated'     => new DateTime,
            'Name'            => 'Test User 2',
            'Comment'         => 'Test getNarrative with child comments.',
        ));

        $childComments[] = Comment::create(array(
            'NarrativeID'     => $id,
            'CommentParentID' => $c->CommentID,
            'DateCreated'     => new DateTime,
            'Name'            => 'Test User 3',
            'Comment'         => 'Test getNarrative with child comments.',
        ));

        $response = $this->action(
            'GET',
            'ApiCommentController@getNarrative',
            array('id' => $id)
        );

        $data = json_decode($response->getContent());

        $data = $data->return[0];

        $this->assertCount(2, $data->children);

        $this->assertEquals($childComments[0]->Name, $data->children[0]->name);
        $this->assertEquals($childComments[0]->Comment, $data->children[0]->body);

        $this->assertEquals($childComments[1]->Name, $data->children[1]->name);
        $this->assertEquals($childComments[1]->Comment, $data->children[1]->body);
    }

    /**
     * Test retrieving an unpublished narrative.
     *
     * @covers ApiCommentController::getNarrative
     */
    public function testGetNarrativeWithUnpublishedAsUser()
    {
        $this->addNarrativeToDatabase(false);

        $id = Narrative::first()->NarrativeID;

        $c = Comment::create(array(
            'NarrativeID' => $id,
            'DateCreated' => new DateTime,
            'Name'        => 'Test User',
            'Comment'     => 'testGetNarrativeWithSingleComment',
        ));

        $response = $this->action(
            'GET',
            'ApiCommentController@getNarrative',
            array('id' => $id),
            array('withUnpublished' => '1')
        );

        $this->assertResponseStatus(404);
    }

    /**
     * Test retrieving an unpublished narrative.
     *
     * @covers ApiCommentController::getNarrative
     */
    public function testGetNarrativeWithUnpublishedAsAdmin()
    {
        $this->addNarrativeToDatabase(false);

        $id = Narrative::first()->NarrativeID;

        $c = Comment::create(array(
            'NarrativeID' => $id,
            'DateCreated' => new DateTime,
            'Name'        => 'Test User',
            'Comment'     => 'testGetNarrativeWithSingleComment',
        ));

        $user = new User(array('email' => 'admin@test.local'));

        $this->be($user);

        $response = $this->action(
            'GET',
            'ApiCommentController@getNarrative',
            array('id' => $id),
            array('withUnpublished' => '1')
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertCount(1, $data->return);
    }

    /**
     * Tests the post action by creating a comment associated to an invalid
     * narrative.
     *
     * @covers ApiCommentController::postNarrative
     */
    public function testPostNarrativeWithInvalidNarrative()
    {
        $response = $this->action(
            'POST',
            'ApiCommentController@postNarrative',
            array('id' => 7),
            array('name' => 'Test User', 'comment' => 'Test comments.')
        );

        $this->assertResponseStatus(404);
    }

    /**
     * Test the post action by creating a comment associated with a published
     * narrative.
     *
     * @covers ApiCommentController::postNarrative
     */
    public function testPostNarrativeWithPublishedNarrative()
    {
        $this->addNarrativeToDatabase();

        $comment = new Comment(array(
            'Name'    => 'Test User',
            'Comment' => 'Test comments.',
        ));

        $response = $this->action(
            'POST',
            'ApiCommentController@postNarrative',
            array('id' => 1),
            array(
                'name' => $comment->Name,
                'comment' => $comment->Comment,
            )
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($comment->Name, $data->return->name);
        $this->assertEquals($comment->Comment, $data->return->body);
    }

    /**
     * Test the post action when validation fails.
     *
     * @covers ApiCommentController::postNarrative
     */
    public function testPostNarrativeWithFailingValidation()
    {
        $this->addNarrativeToDatabase();

        $validator = Mockery::mock('Illuminate\Validation\Factory');

        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(true);
        $validator->shouldReceive('errors')->once()->andReturn(new Illuminate\Support\MessageBag);

        Validator::swap($validator);

        $response = $this->action('POST', 'ApiCommentController@postNarrative', array('id' => 1));

        $this->assertResponseStatus(400);
    }

    /**
     * Test the post action when Comment saving fails.
     *
     * @covers ApiCommentController::postNarrative
     */
    public function testPostNarrativeWithCommentSaveFail()
    {
        $this->addNarrativeToDatabase();

        $validator = Mockery::mock('Illuminate\Validation\Factory');
        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::swap($validator);

        $this->mock = Mockery::mock('Eloquent', 'Comment');
        $this->mock->shouldReceive('create')->once()->andReturn(false);
        App::instance('Comment', $this->mock);

        $response = $this->action('POST', 'ApiCommentController@postNarrative', array('id' => 1));

        $this->assertResponseStatus(500);
    }

    /**
     * Test the postFlag action with appropriate values; should result in a
     * successful operation.
     *
     * @covers ApiCommentController::postFlag
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostFlagSuccess()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $reasoning = 'Test postFlag success: reasoning';

        $response = $this->action(
            'POST',
            'ApiCommentController@postFlag',
            array('id' => $c->CommentID),
            array(
                'reasoning' => $reasoning,
            )
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);

        $flags = $c->flags()->get();

        $this->assertCount(1, $flags);

        $f = $flags->first();

        $this->assertEquals($reasoning, $f->Comment);
    }

    /**
     * Test the postFlag action with the missing `reasoning` parameter.
     *
     * @covers ApiCommentController::postFlag
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostFlagWithMissingParameter()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postFlag',
            array('id' => $c->CommentID)
        );

        $this->assertResponseStatus(400);
    }

    /**
     * Test the postFlag action by attempting to flag a non-existent comment.
     *
     * @covers ApiCommentController::postFlag
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostFlagWithMissingComment()
    {
        $this->addNarrativeToDatabase();

        $reasoning = 'Test postFlag success: reasoning';

        $response = $this->action(
            'POST',
            'ApiCommentController@postFlag',
            array('id' => 1),
            array(
                'reasoning' => $reasoning,
            )
        );

        $this->assertResponseStatus(404);
    }

    /**
     * Test the postFlag action by attempting to flag an unpublished
     * narrative's comment.
     *
     * @covers ApiCommentController::postFlag
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostFlagWithUnpublishedNarrative()
    {
        $this->addNarrativeToDatabase(false);

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $reasoning = 'Test postFlag success: reasoning';

        $response = $this->action(
            'POST',
            'ApiCommentController@postFlag',
            array('id' => $c->CommentID),
            array(
                'reasoning' => $reasoning,
            )
        );

        $this->assertResponseStatus(404);
    }

    /**
     * Test the postFlag action with a failing database save attempt.
     *
     * @covers ApiCommentController::postFlag
     * @uses   Narrative
     * @uses   Comment
     * @uses   Flag
     */
    public function testPostFlagWithSaveFail()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $reasoning = 'Test postFlag success: reasoning';

        $flag = Mockery::mock('Eloquent', 'Flag');
        $flag->shouldReceive('create')->once()->andReturn(false);
        App::instance('Flag', $flag);

        $response = $this->action(
            'POST',
            'ApiCommentController@postFlag',
            array('id' => $c->CommentID),
            array(
                'reasoning' => $reasoning,
            )
        );

        $this->assertResponseStatus(500);
    }

    /**
     * Test the postVote action with appropriate data to agree with comment.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteAgree()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID),
            array('agree' => 'true')
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($c->Name, $data->return->name);
        $this->assertEquals(1, $data->return->agrees);
        $this->assertEquals(0, $data->return->disagrees);
    }

    /**
     * Test postVote action with appropriate data to disagree with comment.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteDisagree()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID),
            array('agree' => 'false')
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($c->Name, $data->return->name);
        $this->assertEquals(0, $data->return->agrees);
        $this->assertEquals(1, $data->return->disagrees);
    }

    /**
     * Test postVote action with option to swap a disagree to agree vote.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteWithSwapToAgree()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
            'Agrees'      => 5,
            'Disagrees'   => 3,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID),
            array('agree' => 'true', 'swap' => 'true')
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($c->Name, $data->return->name);
        $this->assertEquals(6, $data->return->agrees);
        $this->assertEquals(2, $data->return->disagrees);
    }

    /**
     * Test postVote action with option to swap an agree to disagree vote.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteWithSwapToDisagree()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
            'Agrees'      => 5,
            'Disagrees'   => 3,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID),
            array('agree' => 'false', 'swap' => 'true')
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($c->Name, $data->return->name);
        $this->assertEquals(4, $data->return->agrees);
        $this->assertEquals(4, $data->return->disagrees);
    }

    /**
     * Test the postVote action to ensure that counts are incremented properly.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteIncrement()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
            'Agrees'      => 10,
            'Disagrees'   => 7,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID),
            array('agree' => 'false')
        );

        $this->assertResponseOk();

        $data = json_decode($response->getContent());

        $this->assertTrue($data->success);
        $this->assertEquals($c->Name, $data->return->name);
        $this->assertEquals(10, $data->return->agrees);
        $this->assertEquals(8, $data->return->disagrees);
    }

    /**
     * Test the postVote action with the missing `agree` parameter.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteWithMissingParameter()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
            'Agrees'      => 10,
            'Disagrees'   => 7,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID)
        );

        $this->assertResponseStatus(400);
    }

    /**
     * Test the postVote action with a non-existent comment.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteWithMissingComment()
    {
        $this->addNarrativeToDatabase();

        $n = Narrative::first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => 1),
            array('agree' => 'true')
        );

        $this->assertResponseStatus(404);
    }

    /**
     * Test the postVote action with a comment on an unpublished
     * narrative.
     *
     * @covers ApiCommentController::postVote
     * @uses   Narrative
     * @uses   Comment
     */
    public function testPostVoteWithUnpublishedNarrative()
    {
        $this->addNarrativeToDatabase(false);

        $n = Narrative::first();

        $n->comments()->save(new Comment(array(
            'Name'        => 'Unit Test User 1',
            'Comment'     => 'Test postFlag success.',
            'DateCreated' => new DateTime,
        )));

        $c = $n->comments()->first();

        $response = $this->action(
            'POST',
            'ApiCommentController@postVote',
            array('id' => $c->CommentID),
            array('agree' => 'true')
        );

        $this->assertResponseStatus(404);
    }

}
