<?php

class AdminFlagControllerTest extends TestCase
{
    /**
     * Test that will test AdminFlagControllers getIndex method
     *
     * @covers AdminFlagController::getIndex
     */
    public function testIndex()
    {
        $user = new User(array('email' => 'thomas@rahn.ca'));
        $this->be($user);
        $response = $this->call('GET', 'admin/narrative/flag/1');

        $this->assertResponseOk();
    }

    /**
     * Test that will test AdminFlagControllers desotry method
     *
     * @covers AdminFlagController::destroy
     */
    public function testDestroy()
    {
        $flag = new Flag;
        $flag->FlagID = 1;
        $flag->NarrativeID = 1;
        $flag->Comment = "test";
        $flag->CommentID = NULL;

        $flag->save();

        $flag = Flag::find(1);
        $this->assertNotNull($flag);

        $response = $this->call('DELETE', 'admin/narrative/flag/1'); 

        $flag = Flag::find(1);
        $this->assertNull($flag);
    }
    
}
