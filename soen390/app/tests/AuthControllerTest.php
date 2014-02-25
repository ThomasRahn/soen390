<?php

class AuthControllerTest extends TestCase
{
	/**
	 * Test Index
	 */
	public function testCreate()
	{
		  $this->call('GET', 'auth/login');
 
		  $this->assertResponseOk();
	}
	/**
	 * Test Store failure
	 */
	public function testStoreFailure()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(false);
 
		$this->call('POST', 'auth/login');
 		//$this->assertRedirectedToRoute('auth/login');
	}


	 /**
	 * Test Store success
	 */
	public function testStoreSuccess()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(true);
 
		$this->call('POST', 'auth/login');
 		
		//$this->assertRedirectedToRoute('admin');
	} 
}
