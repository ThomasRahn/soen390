<?php

class AnonymousRouteTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     */
    public function testListing()
    {
        $response = $this->call('GET', '/');
        $view = $response->original;

        $this->assertResponseOk();
        $this->assertEquals('cards/listing', $view->getName());
    }
    
}