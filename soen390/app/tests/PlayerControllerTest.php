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

    /**
     * Attempt to retrieve the player for an unpublished narrative, as an 
     * ordinary user.
     *
     * @covers PlayerController::getPlay
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetPlayWithUnpublishedAsUser()
    {
        $this->addNarrativeToDatabase(false);

        $n = Narrative::first();

        $response = $this->action('GET', 'PlayerController@getPlay', array('id' => $n->NarrativeID), array('withUnpublished' => 1));

        $this->assertResponseStatus(404);
    }

    /**
     * Attempt to retrieve the player for an unpublished narrative, as an 
     * administrator user.
     *
     * @covers PlayerController::getPlay
     */
    public function testGetPlayWithUnpublishedAsAdmin()
    {
        $this->addNarrativeToDatabase(false);

        $n = Narrative::first();

        $this->be(new User(array('email' => 'test@admin.local')));

        $response = $this->action('GET', 'PlayerController@getPlay', array('id' => $n->NarrativeID), array('withUnpublished' => 1));

        $this->assertResponseOk();
    }

}
