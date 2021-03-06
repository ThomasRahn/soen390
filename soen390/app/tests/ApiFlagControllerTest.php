<?php

class ApiFlagControllerTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiFlagController::index
     */
    public function testIndexForJsonResponse()
    {
        $response = $this->action('GET', 'ApiFlagController@index');

        $this->assertResponseOk();
        $this->assertJson($response->getContent());
    }

     /**
     * Test the API's index and ensures that response is valid JSON and has flags.
     *
     * @covers ApiFlagController::index
     */
    public function testIndexWithFlags()
    {
        // Seed necessary values.
        $this->seed('TopicTableSeeder');
        $this->seed('CategoryTableSeeder');
        $this->seed('LanguageTableSeeder');

        // Create a narrative and flag instance.

        $narrative = Narrative::create(array(
                'TopicID'      => 1,
                'CategoryID'   => 1,
                'LanguageID'   => 1,
                'DateCreated'  => new DateTime,
                'Name'         => 'Test',
                'Agrees'       => 1,
                'Disagrees'    => 1,
                'Indifferents' => 1,
                'Published'    => true,
            ));

        $flag = Flag::create(array(
                'NarrativeID' => Narrative::first()->NarrativeID,
                'CommentID'   => null,
                'Comment'     => 'testIndexWithFlags',
            ));

        $response = $this->action('GET', 'ApiFlagController@index', array('NarrativeID' => $narrative->NarrativeID));

        $this->assertJson($response->getContent());

        $jsonResponse = json_decode($response->getContent());

        $this->assertEquals(1, count($jsonResponse));

        $responseFlag = $jsonResponse[0];

        $this->assertEquals($flag->FlagID, $responseFlag->id);
        $this->assertEquals($narrative->Name, $responseFlag->name);
        $this->assertEquals($flag->NarrativeID, $responseFlag->narrativeID);
        $this->assertEquals($flag->Comment, $responseFlag->comment);
    }

     /**
     * Test the API's show and ensures that response is valid JSON and has flags.
     *
     * @covers ApiFlagController::show
     */
    public function testShowWithFlags()
    {
        // Seed necessary values.
        $this->seed('TopicTableSeeder');
        $this->seed('CategoryTableSeeder');
        $this->seed('LanguageTableSeeder');

        // Create a narrative and flag instance.

        $narrative = Narrative::create(array(
                'TopicID'      => 1,
                'CategoryID'   => 1,
                'LanguageID'   => 1,
                'DateCreated'  => new DateTime,
                'Name'         => 'Test',
                'Agrees'       => 1,
                'Disagrees'    => 1,
                'Indifferents' => 1,
                'Published'    => true,
            ));

        $commentCreated = Comment::create(array('NarrativeID'=>$narrative->NarrativeID,'Name'=>'test','Agrees'=>0,'Indifferents'=>1,'Disagrees'=>1,'DateCreated'=>date('Y-m-d H:i:s'), 'Comment'=>'TEST'));

        $flag = Flag::create(array(
                'NarrativeID' => Null,
                'CommentID'   => Comment::first()->CommentID,
                'Comment'     => 'testIndexWithFlags',
            ));

        $response = $this->call('GET', 'api/flags/comments', array('CommentID' => $commentCreated->CommentID));


        $this->assertJson($response->getContent());

        $jsonResponse = json_decode($response->getContent());

        $this->assertEquals(1, count($jsonResponse));

        $responseFlag = $jsonResponse[0];

        $this->assertEquals($flag->FlagID, $responseFlag->id);
        $this->assertEquals($commentCreated->Name, $responseFlag->name);
        $this->assertEquals($flag->CommentID, $responseFlag->commentID);
        $this->assertEquals($flag->Comment, $responseFlag->comment);
    }

}
