<?php

class BaseController extends Controller {

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Flashses the result of a request action for later display in the view.
	 * Data is available from the Session object in `action.failed` and `action.message` keys.
	 * An optional `Illuminate\Http\RedirectResponse` can be provided if a single line alert-redirect action is preferred.
	 *
	 * @param  $hasFailed  boolean
	 * @param  $message    string
	 * @param  $redirector RedirectResponse
	 * @return Illuminate\Http\RedirectResponse
	 */
	protected function alertAction($hasFailed, $message, Illuminate\Http\RedirectResponse $redirector = null)
	{
		Session::flash('action.failed', $hasFailed);
		Session::flash('action.message', $message);

		return $redirector;
	}

}