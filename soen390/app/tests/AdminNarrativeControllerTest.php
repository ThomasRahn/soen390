<?php

class AdminNarrativeControllerTest extends TestCase
{

    /**
    * Test that will test the narrative desotry method
    *
    * @covers AdminNarrativeController::destroy
     */
    public function testDestroy()
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

        $narrative = Narrative::find(1);
    	$this->assertNotNull($narrative);

        $response = $this->call('DELETE', 'admin/narrative/narrative/1'); 

        $narrative1 = Narrative::find(1);
    	$this->assertNull($narrative1);
    	
    }
    
}
