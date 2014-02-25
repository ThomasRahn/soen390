<?php

class NarrativeControllerTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     */
    public function testIndexView()
    {
        $user = new User(array('email' => 'thomas@rahn.ca'));
        $this->be($user);
        $response = $this->call('GET', 'admin/narrative');

        $this->assertResponseOk();
    }

}
