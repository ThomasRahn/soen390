<?php

class PlayerControllerTest extends TestCase
{

    /**
     * Attempt to retrieve the player for an invalid narrative ID. Should
     * result in a 404 response and exception.
     *
     * @covers PlayerController::getPlay
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetPlayWithInvalidId()
    {
        $response = $this->action('GET', 'PlayerController@getPlay', array('id' => 70));

        $this->assertResponseStatus(404);
    }

    /**
     * Attempt to retrieve the player with a valid narrative ID.
     *
     * @covers PlayerController::getPlay
     */
    public function testGetPlayWithValidId()
    {
        $this->addNarrativeToDatabase();

        $id = Narrative::first()->NarrativeID;

        $response = $this->action('GET', 'PlayerController@getPlay', array('id' => $id));

        $this->assertResponseOk();
        $this->assertEquals('player.popup', $response->original->getName());
        $this->assertViewHas('narrativeApiPath');
        $this->assertViewHas('commentsApiPath');
    }

}
