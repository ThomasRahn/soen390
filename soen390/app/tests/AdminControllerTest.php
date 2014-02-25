<?php

class AdminControllerTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     */
    public function testDashbaord()
    {
        $user = new User(array('email' => 'thomas@rahn.ca'));
        $this->be($user);

        $response = $this->call('GET', '/admin');
        $view = $response->original;

        $this->assertResponseOk();
    }
    
}
