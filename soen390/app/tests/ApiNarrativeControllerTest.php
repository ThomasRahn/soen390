<?php

class ApiNarrativeControllerTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers \ApiNarrativeControllerTest::index
     */
    public function testIndex()
    {
        $response = $this->call('GET', 'api/narrative');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

}
