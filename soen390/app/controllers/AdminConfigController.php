<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class AdminConfigController extends \BaseController
{

    /**
     * @return  View
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
        ));

        if ($validator->fails()) {
            return Redirect::back(400)->withErrors($validator)->withInput();
        }

        $hasFailed = false;

        // Set Maintenance Mode
        $maintenance = Input::get('maintenance', 'false');
        $hasFailed = $hasFailed || (! Configuration::set('maintenance', $maintenance));

        return $this->alertAction(
            $hasFailed,
            ($hasFailed ? trans('admin.configuration.save.failed') : trans('admin.configuration.save.success')),
            Redirect::back()
        );
    }

}
