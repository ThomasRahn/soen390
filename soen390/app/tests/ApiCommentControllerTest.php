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

}
