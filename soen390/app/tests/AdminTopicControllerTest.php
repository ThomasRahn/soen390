<?php

class AdminTopicControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->be(new User(array('email' => 'admin@user.local')));
    }

    /**
     * @covers AdminTopicController::getIndex
     */
    public function testGetIndex()
    {
        $response = $this->action('GET', 'AdminTopicController@getIndex');

        $this->assertResponseOk();
        $this->assertViewHas('topics');
    }

    /**
     * @covers AdminTopicController::getIndex
     */
    public function testGetIndexForTopics()
    {
        $response = $this->action('GET', 'AdminTopicController@getIndex');

        $view = $response->original;

        $this->assertCount(Topic::all()->count(), $view['topics']);
    }

    /**
     * @covers AdminTopicController::getSingle
     */
    public function testGetSingle()
    {
        $topic = Topic::first();

        $response = $this->action('GET', 'AdminTopicController@getSingle', array('id' => $topic->TopicID));

        $jsonResponse = json_decode($response->getContent());

        $this->assertTrue($jsonResponse->success);

        $jsonTopic = $jsonResponse->return;

        $this->assertEquals($topic->TopicID, $jsonTopic->id);
        $this->assertEquals($topic->Name, $jsonTopic->name);
        $this->assertEquals($topic->narratives()->count(), $jsonTopic->narrativeCount);
    }

    /**
     * @covers AdminTopicController::getSingle
     */
    public function testGetSingleWithInvalidID()
    {
        $topicCount = Topic::all()->count();

        $response = $this->action('GET', 'AdminTopicController@getSingle', array('id' => $topicCount + 1));

        $this->assertResponseStatus(404);
    }

    /**
     * @covers AdminTopicController::putTogglePublish
     */
    public function testPutTogglePublish()
    {
        $topic = Topic::first();

        $response = $this->action('PUT', 'AdminTopicController@putTogglePublish', array('id' => $topic->TopicID));

        $jsonTopic = json_decode($response->getContent())->return;

        $this->assertNotEquals($topic->Published, Topic::first()->Published);
        $this->assertNotEquals($topic->Published, $jsonTopic->published);
    }

    /**
     * @covers AdminTopicController::putTogglePublish
     */
    public function testPutTogglePublishWithInvalidID()
    {
        $topicCount = Topic::get()->count();

        $response = $this->action('PUT', 'AdminTopicController@putTogglePublish', array('id' => $topicCount + 1));

        $this->assertResponseStatus(404);
    }

    /**
     * @covers AdminTopicController::putSingle
     */
    public function testPutSingle()
    {
        $topic = Topic::first();

        $response = $this->action(
            'PUT',
            'AdminTopicController@putSingle',
            array('id' => $topic->TopicID),
            array(
                'code'   => 'test-code',
                'descEn' => 'test description',
                'descFr' => 'test description',
            )
        );

        $this->assertResponseOk();

        $jsonTopic = json_decode($response->getContent())->return;

        $this->assertEquals($topic->TopicID, $jsonTopic->id);
        $this->assertEquals('test-code', $jsonTopic->name);
        $this->assertEquals('test description', $jsonTopic->description);
    }

    /**
     * @covers AdminTopicController::putSingle
     */
    public function testPutSingleValidation()
    {
        $topic = Topic::first();

        $response = $this->action(
            'PUT',
            'AdminTopicController@putSingle',
            array('id' => $topic->TopicID),
            array(
                'code'   => 'Invalid Code With Spaces',
                'descEn' => 'test description',
                'descFr' => 'test description',
            )
        );

        $this->assertResponseStatus(400);
        $this->assertNotEquals('Invalid Code With Spaces', Topic::first()->Name);
    }

    /**
     * @covers AdminTopicController::putSingle
     */
    public function testPutSingleWithInvalidID()
    {
        $topicCount = Topic::all()->count();

        $response = $this->action(
            'PUT',
            'AdminTopicController@putSingle',
            array('id' => $topicCount + 1),
            array(
                'code'   => 'test-code',
                'descEn' => 'test description',
                'descFr' => 'test description',
            )
        );

        $this->assertResponseStatus(404);
    }

    /**
     * @covers AdminTopicController::postAdd
     */
    public function testPostAdd()
    {
        $response = $this->action(
            'POST',
            'AdminTopicController@postAdd',
            array(),
            array(
                'code'   => 'test-code',
                'descEn' => 'test description',
                'descFr' => 'test description',
            )
        );

        $this->assertResponseOk();

        $this->assertCount(2, Topic::all());

        $jsonTopic = json_decode($response->getContent())->return;

        $this->assertEquals('test-code', $jsonTopic->name);
        $this->assertEquals('test description', $jsonTopic->description);
    }

    /**
     * @covers AdminTopicController::postAdd
     */
    public function testPostAddValidation()
    {
        $response = $this->action(
            'POST',
            'AdminTopicController@postAdd',
            array(),
            array(
                'code'   => 'Invalid Code With Spaces',
                'descEn' => '',
                'descFr' => 'test description',
            )
        );

        $this->assertResponseStatus(400);
    }
}
