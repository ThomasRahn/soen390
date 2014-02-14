<?php

class NarrativeControllerTest extends TestCase
{

    /**
     * Test that the root route will return the cards listing view.
     */
    public function testIndexView()
    {
        $response = $this->call('GET', '/admin/manage');
        $view = $response->original;

        $this->assertResponseOk();
        $this->assertEquals('admin/manage', $view->getName());
    }
    public function testGetAllNarratives(){
	$response = $this->call('GET', '/admin/manage');
	$this->assertViewHas('narratives');
	

	$narratives = $response->original->getData()['narratives'];
	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $narratives);
	
    }

    public function testNarrativeShow(){
	$response = $this->call('GET', '/narrative/1');
        $this->assertViewHas('narrative');


        $narrative = $response->original->getData()['narrative'];
        $this->assertInstanceOf('Narrative', $narrative);
    }  
}
