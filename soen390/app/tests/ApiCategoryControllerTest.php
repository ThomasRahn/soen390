<?php

class ApiCategoryControllerTest extends TestCase
{

 	/**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiCategoryController::index
     */
    public function testIndex()
    {
        $response = $this->call('GET', 'api/category');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }




}