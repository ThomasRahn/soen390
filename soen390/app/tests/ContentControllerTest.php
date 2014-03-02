<?php

class ContentControllerTest extends TestCase
{

    /**
     * Attempt to get a media file that doesn't exist.
     *
     * @covers            ContentController::getContent
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetNonExistantContent()
    {
        $response = $this->action('GET', 'ContentController@getContent', array('id' => 10));

        $this->assertResponseStatus(404);
    }

    /**
     * Attempt to get an existant media file.
     *
     * @covers ContentController::getContent
     */
    public function testGetExistingContent()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

}
