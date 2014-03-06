<?php

class AdminProfileControllerTest extends \TestCase
{

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * @covers AdminProfileController::getIndex
     */
    public function testGetIndexWithAuthenticatedUser()
    {
        $user = new User(array('email' => 'admin@user.local'));
        $this->be($user);

        $response = $this->action('GET', 'AdminProfileController@getIndex');

        $this->assertResponseOk();

        $view = $response->original;

        $this->assertEquals('admin.profile.index', $view->getName());
        $this->assertViewHas('user');
        $this->assertViewHas('languages');
    }

    /**
     * @covers AdminProfileController::postIndex
     */
    public function testPostIndexWithoutPasswordChange()
    {
        $userPassword = 'testPassword';

        $user = new User(array(
            'Email' => 'admin@user.local',
            'Password' => Hash::make($userPassword),
            'Name' => 'Johnny Testee',
        ));

        $this->be($user);

        $this->seed('LanguageTableSeeder');

        $language = Language::first();

        $validator = Mockery::mock('Illuminate\Validation\Factory');
        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::swap($validator);

        $input = array(
            'Name'       => 'Johnny Test',
            'Email'      => 'john@user.local',
            'LanguageID' => $language->LanguageID, 
        );

        $response = $this->action(
                'POST',
                'AdminProfileController@postIndex',
                array(),
                $input
            );

        $this->assertRedirectedToAction('AdminProfileController@getIndex');
        $this->assertSessionHas('action.failed', false);

        $authUser = Auth::user();

        $this->assertEquals($input['Name'], $authUser->Name);
        $this->assertEquals($input['Email'], $authUser->Email);
        $this->assertEquals($input['LanguageID'], $authUser->LanguageID);
        $this->assertTrue(Auth::validate(array(
                'email'    => $input['Email'],
                'password' => $userPassword,
            )));
    }

    /**
     * @covers AdminProfileController::postIndex
     */
    public function testPostIndexWithPasswordChange()
    {
        $userPassword = 'testPassword';
        $changePassword = 'drowssaPtset';

        $user = new User(array(
            'Email' => 'admin@user.local',
            'Password' => Hash::make($userPassword),
            'Name' => 'Johnny Testee',
        ));

        $this->be($user);

        $this->seed('LanguageTableSeeder');

        $language = Language::first();

        $validator = Mockery::mock('Illuminate\Validation\Factory');
        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(false);
        Validator::swap($validator);

        $input = array(
            'Name'                  => 'Johnny Test',
            'Email'                 => 'john@user.local',
            'LanguageID'            => $language->LanguageID,
            'Password'              => $changePassword,
            'Password_confirmation' => $changePassword,
        );

        $response = $this->action(
                'POST',
                'AdminProfileController@postIndex',
                array(),
                $input
            );

        $this->assertRedirectedToAction('AdminProfileController@getIndex');
        $this->assertSessionHas('action.failed', false);

        $authUser = Auth::user();

        $this->assertEquals($input['Name'], $authUser->Name);
        $this->assertEquals($input['Email'], $authUser->Email);
        $this->assertEquals($input['LanguageID'], $authUser->LanguageID);
        $this->assertTrue(Auth::validate(array(
                'email'    => $input['Email'],
                'password' => $changePassword,
            )));
    }

    /**
     * @covers AdminProfileController::postIndex
     */
    public function testPostIndexWithFailingValidation()
    {
        $userPassword = 'testPassword';

        $user = User::create(array(
            'Email' => 'admin@user.local',
            'Password' => Hash::make($userPassword),
            'Name' => 'Johnny Testee',
        ));

        $this->be($user);

        $this->seed('LanguageTableSeeder');

        $language = Language::first();

        $validator = Mockery::mock('Illuminate\Validation\Factory');
        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(true);
        Validator::swap($validator);

        $input = array(
            'Name'                  => 'Johnny Test',
            'Email'                 => 'john@user.local',
            'LanguageID'            => $language->LanguageID,
        );

        $response = $this->action(
                'POST',
                'AdminProfileController@postIndex',
                array(),
                $input
            );

        $this->assertRedirectedToAction('AdminProfileController@getIndex');
        $this->assertSessionHas('action.failed', true);
        $this->assertSessionHas('errors');

        $authUser = Auth::user();

        $this->assertEquals($user->Name, $authUser->Name);
        $this->assertEquals($user->Email, $authUser->Email);
        $this->assertEquals($user->LanguageID, $authUser->LanguageID);
        $this->assertTrue(Auth::validate(array(
                'email'    => 'admin@user.local',
                'password' => 'testPassword',
            )));
    }

}
