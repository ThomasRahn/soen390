<?php

class AuthControllerTest extends TestCase
{
	/**
	 * Setup the authentication test run by seeding the database and starting
	 * the session.
	 *
	 * @return  void
	 */
	public function setUp()
	{
		parent::setUp();
		Session::start();
		$this->seed('UserTableSeeder');
	}

	/**
	 * Clean up when the test run is complete.
	 *
	 * @return  void
	 */
	public function tearDown()
	{
		Mockery::close();
	}

	/**
	 * Test retrieving the login form.
	 *
	 * @covers AuthController::getLogin
	 */
	public function testGetLoginForm()
	{
		  $this->call('GET', 'auth/login');
 
		  $this->assertResponseOk();
	}

	/**
	 * Test valid authentication attempt.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginWithValidCredentials()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertTrue(Auth::check());
	}


	/**
	 * Test invalid authentication attempt where the user email does not
	 * exist.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginWithInvalidEmail()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'jane@doe.com',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

	/**
	 * Test invalid authentication attempt where the user password does not
	 * properly match, but the email is correct.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginWithInvalidPassword()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'abc123',
				'_token' => csrf_token(),
				)
			);

		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

	/**
	 * Test completely invalid authentication attempt.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginWithInvalidCredentials()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'jane@doe.com',
				'password' => 'abc123',
				'_token' => csrf_token(),
				)
			);

		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

	/**
	 * Test authentication case sensitivity for email field.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginEmailCaseSensitivity()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'THOMAS@RAHN.CA',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

	/**
	 * Test authentication case sensitivity for password field.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginPasswordCaseSensitivity()
	{
		$response = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'THOMAS1',
				'_token' => csrf_token(),
				)
			);

		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
	}

	/**
	 * Test the logout action.
	 *
	 * @covers AuthController::getLogout
	 */
	public function testGetLogoutWhenAuthenticated()
	{
		// Login first

		$loginResponse = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertTrue(Auth::check());

		// Logout now

		$logoutResponse = $this->route('GET', 'logout');

		$this->assertFalse(Auth::check());
	}

	/**
	 * Test the authentication with failing validation.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginFailedValidation()
	{
		$validator = Mockery::mock('Illuminate\Validation\Factory');

		$validator->shouldReceive('make')->once()->andReturn($validator);
		$validator->shouldReceive('fails')->once()->andReturn(true);

		Validator::swap($validator);

		$loginResponse = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertFalse(Auth::check());
		$this->assertRedirectedToRoute('login');
		$this->assertSessionHasErrors();
	}

	/**
	 * Test to ensure that failing attempts redirect with old input.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginAuthFailureHasOldInputs()
	{
		Auth::shouldReceive('attempt')->once()->andReturn(false);

		$loginResponse = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertHasOldInput();
	}

	/**
	 * Test to ensure that in the event that the user password value requires
	 * a rehash, it succeeds.
	 *
	 * @covers AuthController::postLogin
	 */
	public function testPostLoginNeedRehash()
	{
		$hasher = Mockery::mock('Illuminate\Hashing\BcryptHasher');

		$hasher->shouldReceive('needsRehash')->once()->andReturn(true);

		$loginResponse = $this->call(
			'POST',
			'auth/login',
			array(
				'email' => 'thomas@rahn.ca',
				'password' => 'Thomas1',
				'_token' => csrf_token(),
				)
			);

		$this->assertTrue(Auth::check());
	}

}
