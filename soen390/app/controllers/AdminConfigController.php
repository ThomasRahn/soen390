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
        return View::make('admin.configuration.index');
    }

    /**
     * @return  ResponseRedirector
     */
    public function postIndex()
    {

    }

}
