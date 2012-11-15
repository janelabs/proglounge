<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Mylibrary extends CI_Controller
{	
	function __construct()
	{
		
	}
	
	function checkUserSession($user_session)
	{
		$isset_uid = (isset($user_session['id']));
		$isset_uname = (isset($user_session['username']));
		
		if ($isset_uid && $isset_uname) {
			return TRUE;
		}
		
		return FALSE;

	}
	
	function isYourProfile($viewer_username, $viewing_username)
	{
		//if user is viewing other profile.
		$viewer_type = 'not_you';
		
		//if user is viewing his/her profile.
		if ($viewer_username == $viewing_username) {
			$viewer_type = 'you';
		}
		
		//if user is not logged in.
		if ($viewer_username == '') {
			$viewer_type = 'guest';
		}
		
		return $viewer_type;
	}
	
	
}// class Mylibrary

/* EOF Mylibrary.php */
/* Location: ./application/libraries/Mylibrary.php */