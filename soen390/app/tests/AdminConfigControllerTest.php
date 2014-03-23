<?php

class AdminConfigControllerTest extends TestCase
{

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * Tests the getIndex function with an empty database.
     *
     * @covers AdminConfigController::getIndex
     */
    public function testGetIndexWithEmptyDatastore()
    {
        $user = new User(array('email' => 'admin@user.local'));
        $this->be($user);

        $response = $this->action('GET', 'AdminConfigController@getIndex');

        $this->assertResponseOk();

        $view = $response->original;

        $this->assertEquals('admin.configuration.index', $view->getName());
        $this->assertCount(0, $view['configs']);
    }

    /**
     * Tests the getIndex function with a populated database.
     *
     * @covers AdminConfigController::getIndex
     */
    public function testGetIndexWithPopulatedDatastore()
    {
        $user = new User(array('email' => 'admin@user.local'));
        $this->be($user);

        Configuration::set('maintenance', 'false');

        $response = $this->action('GET', 'AdminConfigController@getIndex');

        $this->assertResponseOk();

        $view = $response->original;

        $this->assertEquals('admin.configuration.index', $view->getName());
        $this->assertCount(1, $view['configs']);
    }

    /**
     * @covers AdminConfigController::postIndex
     */
    public function testPostIndexWithEmptyDatastore()
    {
        $user = new User(array('email' => 'admin@user.local'));
        $this->be($user);

        $response = $this->action(
            'POST',
            'AdminConfigController@postIndex',
            array(),
            array(
                'maintenance' => 'true',
                'support'     => 'admin@user.local',
            )
        );

        $this->assertRedirectedToAction('AdminConfigController@getIndex');

        $this->assertSessionHas('action.failed', false);
    }

    public function testPostIndexWithFailingValidation()
    {
        $user = new User(array('email' => 'admin@user.local'));
        $this->be($user);

        $validator = Mockery::mock('Illuminate\Validation\Factory');
        $validator->shouldReceive('make')->once()->andReturn($validator);
        $validator->shouldReceive('fails')->once()->andReturn(true);

        Validator::swap($validator);

        $response = $this->action(
            'POST',
            'AdminConfigController@postIndex'
        );

        $this->assertRedirectedToAction('AdminConfigController@getIndex');

        $this->assertSessionHas('action.failed', true);
        $this->assertSessionHas('errors');
    }

}
