<?php

class AdminNarrativeControllerTest extends TestCase
{

    /**
     * Check for proper view and response code.
     *
     * @covers AdminNarrativeController::getIndex
     */
    public function testGetIndex()
    {
        // Set the user
        $user = new User(array('email' => 'user@domain.local'));
        $this->be($user);

        $response = $this->action('GET', 'AdminNarrativeController@getIndex');
        $view = $response->original;

        $this->assertResponseOk();
        $this->assertEquals('admin.narratives.index', $view->getName());
    }
    
    /**
     * Check for proper view and response code along with the correct number
     * of categories.
     *
     * @covers AdminNarrativeController::getUpload
     */
    public function testGetUpload()
    {
        // Set the user
        $user = new User(array('email' => 'user@domain.local'));
        $this->be($user);

        $this->seed('CategoryTableSeeder');
        $categories = Category::all()->count();

        $response = $this->action('GET', 'AdminNarrativeController@getUpload');
        $view = $response->original;

        $this->assertResponseOk();
        $this->assertEquals('admin.narratives.upload', $view->getName());
        $this->assertViewHas('categoryArray');
        $this->assertEquals($categories, count($view['categoryArray']));
    }

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
