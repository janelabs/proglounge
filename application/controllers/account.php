<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Account extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('Users_model', 'user');
	}
	
	/*
     * Views registration form
     */
    public function register()
    {
    	$data['register_error'] = $this->session->flashdata('register_error');
    	$data['user_input'] = $this->session->flashdata('user_input');
        $this->load->view('register_view', $data);
    }
    
    public function saveUser()
    {
    	$input = $this->input->post(NULL, TRUE);

    	//validate inputs
    	if (in_array('', $input)) {
    		$this->session->set_flashdata('register_error', 'Ooopss! You forgot some fields');
    		$input['password'] = '';
    		$input['repassword'] = '';
    		$this->session->set_flashdata('user_input', $input);
    		redirect('register');
    	}
    	
    	if ($input['password'] != $input['repassword']) {
    		$this->session->set_flashdata('register_error', 'Hey! Password did not match.');
    		$input['password'] = '';
    		$input['repassword'] = '';
    		$this->session->set_flashdata('user_input', $input);
    		redirect('register');
    	}
    	    	
    	//check username if exists.
    	$is_exist = (count($this->user->retrieveByUsername($input['username'], 'id')) > 0);
    	if ($is_exist) {
    		$this->session->set_flashdata('register_error', 'Oh no! Username already exist');
    		$input['password'] = '';
    		$input['repassword'] = '';
    		$this->session->set_flashdata('user_input', $input);
    		redirect('register');
    	}
    	
    	unset($input['repassword']);
    	
    	//encrypt password
    	$input['password'] = md5($input['password']);
    	
    	$this->user->saveUser($input);
    	
    	//set session
    	$session_data = array('id' => $this->db->insert_id(),
    			              'username' => $input['username'],
    			              'is_new' => TRUE);
    	$this->session->set_userdata($session_data);
    	
    	redirect($input['username']);
    	
    }
    
    public function checkLogin()
    {
    	$user_input = $this->input->post(NULL, TRUE);
		
    	//check if input is empty.
    	if ($user_input['username'] == '' && $user_input['password'] == '') {
    		$this->session->set_flashdata('login_error', 'Please input your username and password');
    		redirect('login');
    	}
    	
    	if ($user_input['username'] == '') {
    		$this->session->set_flashdata('login_error', 'Please input your username');
    		redirect('login');
    	}
    	
    	if ($user_input['password'] == '') {
    		$this->session->set_flashdata('login_error', 'Please input your password');
    		redirect('login');
    	}
    	
    	$user_input['password'] = md5($user_input['password']);
    	
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
    	$session_data = array('id' => '',
    			              'username' => '',
    			              'is_new' => FALSE);
    	
    	$this->session->unset_userdata($session_data);
    	redirect();
    }
    
} // class Account

/* EOF account.php */
/* Location: ./application/controllers/account.php */