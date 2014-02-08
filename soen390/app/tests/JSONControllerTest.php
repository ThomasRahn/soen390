<?php

class JSONControllerTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     */
    public function testJSONShow(){
	$response = $this->call('GET', '/jsonNarrative/1');
        $this->assertNotNull($response);


    }  
}
