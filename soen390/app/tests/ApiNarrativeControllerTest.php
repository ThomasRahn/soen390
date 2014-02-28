<?php

class ApiNarrativeControllerTest extends TestCase
{

    /**
     * Clean up after the test run.
     */
    public function tearDown()
    {
        Mockery::close();
    }
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiNarrativeController::index
     */
    public function testIndex()
    {
        $response = $this->call('GET', 'api/narrative');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    /**
     * Test the index action and ensure that, with an empty database,
     * we get a result with length of 0.
     *
     * @covers ApiNarrativeController::index
     */
    public function testIndexWithEmptyDatabase()
    {
        $response = $this->call('GET', 'api/narrative');

        $this->assertResponseOk();

        $jsonResponse = json_decode($response->getContent());

        $this->assertTrue(count($jsonResponse->return) === 0);
    }

}
