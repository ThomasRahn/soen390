<?php

class NarrativeControllerTest extends TestCase
{

    /**
     * Attempt to display an non-existant narrative. This should result in a
     * NotFoundHttpException.
     *
     * @covers            NarrativeController::show
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testShowWithInvalidNarrative()
    {
        $response = $this->action('GET', 'NarrativeController@show', array('id' => 10));

        $this->assertResponseStatus(404);
    }

    /**
     * Display an existing narrative.
     *
     * @covers NarrativeController::show
     */
    public function testShowWithValidNarrative()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

}
