<?php

class ApiCommentControllerTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiCommentController::index
     */
    public function testIndexForJsonResponse()
    {
        $response = $this->action('GET', 'ApiCommentController@index');

        $this->assertResponseOk();
        $this->assertJson($response->getContent());
    }

     /**
     * Test the API's index and ensures that response is valid JSON and has flags.
     *
     * @covers ApiCommentController::index
     */
    public function testIndexWithComments()
    {
        // Seed necessary values.
        $this->seed('TopicTableSeeder');
        $this->seed('CategoryTableSeeder');
        $this->seed('LanguageTableSeeder');

        // Create a narrative and flag instance.
        $date = date('Y-m-d H:i:s');

        $narrative = Narrative::create(array(
                'TopicID'      => 1,
                'CategoryID'   => 1,
                'LanguageID'   => 1,
                'DateCreated'  => $date,
                'Name'         => 'Test',
                'Agrees'       => 1,
                'Disagrees'    => 1,
                'Indifferents' => 1,
                'Published'    => true,
            ));
        $comment = Comment::create(array(
                    'NarrativeID'   => Narrative::first()->NarrativeID,
                    'Name'          => 'Thomas',
                    'Comment'       => 'Fake comment',
                    'DateCreated'   => $date,
                    'Agrees'        => 0,
                    'Disagrees'     => 0,
                ));
    

        $response = $this->action('GET', 'ApiCommentController@index', array('NarrativeID' => $narrative->NarrativeID));

        $this->assertJson($response->getContent());

        $jsonResponse = json_decode($response->getContent());

        $this->assertEquals(1, count($jsonResponse));

        $responseComment = $jsonResponse[0];

        $this->assertEquals($comment->CommentID, $responseComment->id);
        $this->assertEquals($comment->Name, $responseComment->name);
        $this->assertEquals($comment->NarrativeID, $responseComment->narrativeID);
        $this->assertEquals($comment->Comment, $responseComment->comment);
    }

}
