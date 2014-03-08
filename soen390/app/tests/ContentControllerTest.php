<?php

class ContentControllerTest extends TestCase
{

    /**
     * Clean up after the test run.
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * Attempt to get a media file that doesn't exist.
     *
     * @covers            ContentController::getContent
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetNonExistentContent()
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
        $this->addNarrativeToDatabase(true);

        $media = Narrative::first()->media()->images()->first();

        $response = $this->action('GET', 'ContentController@getContent', array('id' => $media->id));

        $this->assertResponseOk();
    }

}
