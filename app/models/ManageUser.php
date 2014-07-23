<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ManageUser extends Eloquent implements UserInterface,RemindableInterface {
	
	protected $table='ManageUser';
	protected $primaryKey = 'username';
	public function getAuthIdentifier()
	{
	    return $this->username;
	}

	public function getAuthPassword()
	{
	    return $this->password;
	}
	
	public function getReminderEmail()
	{
	    return $this->email;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberToken()
	{
	    return $this->remember_token;
	}
	
	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

}
