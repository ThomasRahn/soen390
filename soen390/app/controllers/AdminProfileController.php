<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class AdminProfileController extends \BaseController
{

    /**
     * @return Response
     */
    public function getIndex()
    {
        $user = Auth::user();
        $languages = Language::all()->lists('Description', 'LanguageID');

        return View::make('admin.profile.index')
            ->with('user', $user)
            ->with('languages', $languages);
    }

    /**
     * @return Response
     */
    public function postIndex()
    {
        $user = Auth::user();

        $validator = Validator::make(
                Input::all(),
                array(
                    'Name'       => 'required|min:2',
                    'Email'      => 'required|email|unique:User,Email,' . $user->UserID . ',UserID',
                    'LanguageID' => 'required|exists:Language,LanguageID',
                    'Password'   => 'min:6|confirmed',
                )
            );

        if ($validator->fails())
            return $this->alertAction(
                    true,
                    'There is a mistake in your form. Please correct it and try again.',
                    Redirect::action('AdminProfileController@getIndex')->withErrors($validator)->withInput()
                );

        $user->Email = Input::get('Email');
        $user->Name = Input::get('Name');
        $user->LanguageID = Input::get('LanguageID');

        if (Input::has('Password'))
            $user->Password = Hash::make(Input::get('Password'));

        $success = $user->save();

        if (! $success)
            return $this->alertAction(
                    true,
                    'An internal error occured while trying to save the changes to your profile.',
                    Redirect::action('AdminProfileController@getIndex')->withInput()
                );

        return $this->alertAction(
                false,
                'Your profile has been updated.',
                Redirect::action('AdminProfileController@getIndex')
            );

    }

}
