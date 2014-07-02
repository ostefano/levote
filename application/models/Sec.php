<?php
class Sec extends CI_Model {
	function __construct()
	{
		parent::__construct();
	
		/*
			User auth is :
			0 - Disabled account
			1 - Guest
			2 - Normal User
			8 - Admin
		
		*/
		
		$this->disabled_auth 	= 0;
		$this->user_auth 			= 2;
		$this->admin_auth 		= 8;
	}
	
	// Security model
	
	/* User Authorization Functions */
	
	
	// If the user_auth is NOT >= than the selected level
	// kick out the user!
	// If no argument given, considering the lowest auth possible

	function authorized($level = -1)
	{
		// Minimum auth level is the User Auth
		if ($level == -1)
			$level = $this->user_auth;

		// If this function returns FALSE, then exit
		if (!$this->session->userdata('user_auth'))
		{
			$this->redirect_destroy_session();
		}
		
		
		if ($this->session->userdata('user_auth') < $level)
		{
			$this->redirect_destroy_session();
		}
		// The user is authorized .. let him go on.
	}	
	
	
	// Distroy the user's session and redirect him to /
	function redirect_destroy_session()
	{
		$this->session->sess_destroy();
		redirect('/');		
		die();	
	}
	
	// Return the User auth level 
	function user_auth_level()
	{
		return $this->user_auth;
	}
	// Return the Admin auth level 
	function admin_auth_level()
	{
		return $this->admin_auth;
	}
		
	// Return TRUE if this user is admin
	function user_is_admin()
	{
		return $this->current_auth_lvl() == $this->admin_auth;	
	}
	
	function current_auth_lvl()
	{
		return $this->session->userdata('user_auth');
	}
	/* End Authorization Functions */
	
	/* Password Functions */
	function generatePassword($length=6,$level=2) {
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));

		$validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
		$validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

		$password  = "";
		$counter   = 0;

		while ($counter < $length) {
			$actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
			// All character must be different
			if (!strstr($password, $actChar)) {
				$password .= $actChar;
				$counter++;
			}
		}
		return $password;
	}	
	
	function generateHash ($pass) {
		$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
		return crypt($pass, '$2a$12$' . $salt);
	}
	
	
	function compareHash ($input, $hash) {
		return (strcmp($hash,crypt ($input, $hash)) == 0);	
	}
	
	// Function returns the user ID making the request
	function user_id() {
		return $this->session->userdata('user_id');
	}

	function log($type='info',$module='unknown',$message='',$user_id = -1)
	{
		/* Log type 
		
		- info - for information, statistics, successful logins and changes, etc.
		- alert - for failed logins, failed data
		- warning - for errors or actions that users should not be allowed to do
		- error - for important errors which can affect the stability of the app
		
		*/

		// If the user ID is not set by the calling function 
		// we get it from the user data. If the user data is not set
		// then the user id is -1
		
		if ($user_id == -1 && $this->session->userdata('user_id'))
			$user_id = $this->session->userdata('user_id');
			
		$data['ip'] 		= $this->input->ip_address();	
		$data['module'] 	= $module;
		$data['data'] 		= $message;
		$data['user_id'] 	= $user_id;
		$data['type'] 		= $type;
		
		$this->db->insert('log',$data);
	}
	
}