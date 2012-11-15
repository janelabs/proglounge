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
    
    public function checkLogin()
    {
    	$user_input = $this->input->post(NULL, TRUE);
		var_dump($user_input);
		list($is_existing_user, $user) = $this->user->checkUser($user_input['username'], $user_input['password']);
		
		if ($is_existing_user) {
			$session_data = array('id' => $user[0]['id'],
                                  'username' => $user[0]['username']);
			$this->session->set_userdata($session_data);
			redirect($user[0]['username']);
		} else {
			$this->session->set_flashdata('login_error', 'Invalid Username/Password');
			redirect('login');
		}
    }
    
    public function login()
    {
    	$data['login_error'] = $this->session->flashdata('login_error');
    	$this->load->view('login_view', $data);
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