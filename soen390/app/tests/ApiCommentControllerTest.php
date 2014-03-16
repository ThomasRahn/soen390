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

}
