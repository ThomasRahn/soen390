<?php

class AdminControllerTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     */
    public function testDashbaord()
    {
        $response = $this->call('GET', '/admin');
        $view = $response->original;

        $this->assertResponseOk();
        $this->assertEquals('admin', $view->getName());
    }
    
}
