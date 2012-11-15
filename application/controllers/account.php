<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Account extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model', 'user');
	}
	
	/*
     * Views registration form
     */
    public function register()
    {
        $data['header'] = $this->load->view('header', TRUE);
        $data['footer'] = $this->load->view('footer', TRUE);

        $this->load->view('register', $data);
    }
    
    public function login($username, $password)
    {
		list($is_existing_user, $user) = $this->user->checkUser($username, $password);
		
		if ($is_existing_user) {
			$session_data = array('id' => $user[0]['id'],
                                  'username' => $user[0]['username']);
			$this->session->set_userdata($session_data);
			redirect($user[0]['username']);
		} else {
			
		}
    }
    
    public function logout()
    {
    	$session_data = array('id' => $user[0]['id'],
    			              'username' => $user[0]['username']);
    	
    	$this->session->unset_userdata($session_data);
    	redirect();
    }
    
} // class Account

/* EOF account.php */
/* Location: ./application/controllers/account.php */