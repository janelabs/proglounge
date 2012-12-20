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
        $params = array('is_error' => FALSE);

        //encrypt password
    	$input['password'] = md5($input['password']);
    	
    	$result = $this->user->saveUser($input);
        if (!$result) {
            $params['is_error'] = TRUE;
        }
    	
    	echo json_encode($params);
    	
    }

    public function checkUname()
    {
        $uname = $this->input->post('username', TRUE);
        $query = $this->user->retrieveByUsername($uname, 'id');
        $params = array('is_error' => FALSE, 'is_existing' => FALSE);

        if (!$query) {
            $params['is_error'] = TRUE;
        }

        if ($query->num_rows() > 0) {
            $params['is_existing'] = TRUE;
        }

        echo json_encode($params);
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
    
    //this is a sample function
    public function sample_lang()
    {
        echo "sample.";
    }
    
} // class Account

/* EOF account.php */
/* Location: ./application/controllers/account.php */
