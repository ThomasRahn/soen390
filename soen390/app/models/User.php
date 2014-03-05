<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * @package Model
 */
class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table      = 'User';
	protected $primaryKey = 'UserID';
	public    $timestamps = false;
	public    $guarded    = array('UserID');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('Password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 * @codeCoverageIgnore
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 * @codeCoverageIgnore
	 */
	public function getAuthPassword()
	{
		return $this->Password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 * @codeCoverageIgnore
	 */
	public function getReminderEmail()
	{
		return $this->Email;
	}

}
