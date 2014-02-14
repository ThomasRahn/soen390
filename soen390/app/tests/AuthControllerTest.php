<?php

class AuthControllerTest extends TestCase
{
	/**
	 * Test Index
	 */
	public function testCreate()
	{
		  $this->call('GET', 'login');
 
		  $this->assertResponseOk();
	}
	/**
	 * Test Store failure
	 */
	public function testStoreFailure()
	{
		  Auth::shouldReceive('attempt')->once()->andReturn(false);
 
		  $this->call('POST', '/login');
 
		  $this->assertRedirectedToRoute('/login');
	}


	   /**
	 * Test Store success
	 */
	public function testStoreSuccess()
	{
		  Auth::shouldReceive('attempt')->andReturn(true);
 
		  $this->call('POST', '/login');
 
		  $this->assertRedirectedToRoute('admin');
	} 
}
