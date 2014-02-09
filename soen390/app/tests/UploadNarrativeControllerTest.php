<?php

class UploadNarrativeControllerTest extends TestCase
{


	public function testUploadIndex(){
		$response = $this->call('GET', '/admin/upload');
	        $view = $response->original;

        	$this->assertResponseOk();
	        $this->assertEquals('admin/upload', $view->getName());
	}

 	public function testUploadIndexCategory(){
                $response = $this->call('GET', '/admin/upload');
        
        	$this->assertViewHas('category');
	        $category = $response->original->getData()['category'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category);
	}

}
