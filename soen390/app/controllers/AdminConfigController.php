<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class AdminConfigController extends \BaseController
{

    /**
     * @return  Response
     */
    public function getIndex()
    {
        $configs = Configuration::all();

        return View::make('admin.configuration.index')->with('configs', $configs);
    }

    /**
     * @return  ResponseRedirector
     */
    public function postIndex()
    {
        $validator = Validator::make(Input::all(), array(
            'maintenance' => 'in:true,false,1,0',
            'support'     => 'required|email',
        ));

        if ($validator->fails()) {
            return $this->alertAction(
                true,
                trans('admin.configuration.validator.fails'),
                Redirect::action('AdminConfigController@getIndex')
                    ->withErrors($validator)
                    ->withInput()
            );
        }

        $hasFailed = false;

        // Set Maintenance Mode
        $maintenance = Input::get('maintenance', 'false');
        $hasFailed = $hasFailed || (! Configuration::set('maintenance', $maintenance));

        // Set support email address
        $hasFailed = $hasFailed || (! Configuration::set('supportEmail', Input::get('support')));

        return $this->alertAction(
            $hasFailed,
            ($hasFailed ? trans('admin.configuration.save.failed') : trans('admin.configuration.save.success')),
            Redirect::action('AdminConfigController@getIndex')
        );
    }

}
