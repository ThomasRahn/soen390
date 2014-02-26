<?php

class FlagStanceControllerTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     *
     * @covers FlagStanceConrtoller::flagReport
     */
    public function testReportWithNullNarrative()
    {
    	
    	$response = $this->call('POST', 'flag', array('FlagID'=>1,'NarrativeID'=>1, 'report-comment'=>'test','_token'=>csrf_token()));	
    	$flag = Flag::find(1);
    	$this->assertNull($flag);

    }	

    /**
     * Test that the root route will return the cards listing view.
     *
     * @covers FlagStanceConrtoller::flagReport
     */
    public function testReport()
    {
    	$narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = 1;
        $narrativeCreated->LanguageID = 1;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

    	$response = $this->call('POST', 'flag', array('FlagID'=>1,'NarrativeID'=>1, 'report-comment'=>'test','_token'=>csrf_token()));	
    	$flag = Flag::find(1);
    	$this->assertNotNull($flag);
    }	

    /**
     * Test that the root route will return the cards listing view.
     *
     * @covers FlagStanceConrtoller::setStance
     */
    public function testAgreeVote()
    {
    	$narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = 1;
        $narrativeCreated->LanguageID = 1;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

    	$response = $this->call('POST', 'stance', array('NarrativeID'=>1, 'stance'=>1,'_token'=>csrf_token(),'old'=>false));	

    	$narrative = Narrative::find(1);
    	$this->assertEquals($narrative->Agrees, 2);
    }
    /**
     * Test that the root route will return the cards listing view.
     *
     * @covers FlagStanceConrtoller::setStance
    */
    public function testDisAgreeVote()
    {
    	$narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = 1;
        $narrativeCreated->LanguageID = 1;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

    	$response = $this->call('POST', 'stance', array('NarrativeID'=>1, 'stance'=>2,'_token'=>csrf_token(),'old'=>false));	

    	$narrative = Narrative::find(1);
    	$this->assertEquals($narrative->Disagrees, 2);
    }	
	
	/**
     * Test that the root route will return the cards listing view.
     *
     * @covers FlagStanceConrtoller::setStance
     */
    public function testDisAgreeVoteInToggle()
    {
    	$narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = 1;
        $narrativeCreated->LanguageID = 1;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

    	$response = $this->call('POST', 'stance', array('NarrativeID'=>1, 'stance'=>2,'_token'=>csrf_token(),'old'=>true));	

    	$narrative = Narrative::find(1);
    	$this->assertEquals($narrative->Disagrees, 2);
    	$this->assertEquals($narrative->Agrees, 0);
    }	
    
}
