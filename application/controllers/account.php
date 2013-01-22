<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Account extends CI_Controller
{
    private $key = '';

	function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->model('Users_model', 'user');
        $this->key = $this->config->item('encryption_key');
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

        //default profile picture
        $input['image'] = "default.jpg";

        //encrypt password
    	$input['password'] = md5($input['password']);
    	
    	$result = $this->user->saveUser($input);
        if (!$result) {
            $params['is_error'] = TRUE;
        }
    	
    	echo json_encode($params);
    }

    public function updateUser()
    {
        $user_session = $this->session->all_userdata();
        $is_logged_in = $this->mylibrary->checkUserSession($user_session);

        if(!$is_logged_in) {
            throw new Exception('Invalid Access');
        }

        $data = $this->input->post(NULL, TRUE);

        $this->user->updateUser($user_session['id'], $data);
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
			$session_data = array('id' => $user['id'],
                                  'username' => $user['username'],
                                  'image' => $user['image']);
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

    /**
     * View the form for password recovery
     */
    public function password_recovery()
    {
        $this->load->view('password_recovery');
    }

    /**
     * Validates the information given (Password Recovery)
     */
    public function validate_pword_recovery()
    {
        $recoveryTxt = trim($this->input->post('recoveryTxt', TRUE));

        if(strlen($recoveryTxt) == 0):
            $this->session->set_flashdata('recover_error', 'Please input your Username or Email Address');
            redirect('recover_password');
        else:
            $where = "username LIKE '%$recoveryTxt%' OR email_address LIKE '%$recoveryTxt%'";
            $userInfo = $this->user->getUserByUsernameEmail($where);
            if($userInfo):
                //send email
                $config['protocol'] = 'sendmail';
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $this->email->from('noreply@proglounge.com', "Programmer's Lounge");
                $this->email->to($userInfo->email_address);

                $this->email->subject('Password Recovery');

                $link = site_url('change_password/'.md5($userInfo->id . $this->key));
                $message = 'Hi '.ucwords($userInfo->first_name).'!<br><br>Unfortunately, we cannot grant your request in recovering your password for some security concerns, however, you may change your password through this: <a href="'.$link.'">Change my Password</a><br><br>Best Regards!<br>PL Team';
                $note = '<p style="font-size: 11px; color: #8b0000">If this is not you who requested to change your password, please ignore this message. Thank you.</p>';
                $this->email->message($message."<br><br>".$note);

                $this->email->send();

                $this->session->set_flashdata('recover_success', "Please check your email for instructions.\n(inbox/spam)");
                redirect('recover_password');
            else:
                $this->session->set_flashdata('recover_error', 'Username or Email Address not existing');
                redirect('recover_password');
            endif;
        endif;
    }

    /**
     * View change password form
     *
     * @param $id
     */
    public function change_password($id)
    {
        $userInfo['uid'] = $id;
        $this->load->view('change_password', $userInfo);
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        $id = trim($this->input->post('uid', TRUE));
        $new_password = trim($this->input->post('password', TRUE));

        if(strlen($new_password) == 0):
            $this->session->set_flashdata('change_error', 'Please enter a password. Note: White spaces in your password will be removed.');
            redirect(site_url("change_password/".$id));
        else:
            $users = $this->user->getUsers();

            foreach($users AS $user):
                if(md5($user->id . $this->key) == $id){
                    $userInfo = array(
                        'password' => md5($new_password),
                        'date_modified' => date('Y-m-d')
                    );

                    $update = $this->user->updateUser($user->id, $userInfo);
                    if($update):
                        redirect(site_url());
                    else:
                        $this->session->set_flashdata('change_error', 'Something went wrong while saving your password. Please try again.');
                        redirect(site_url("change_password/".$id));
                    endif;
                    break;
                }
                else{
                    $this->session->set_flashdata('change_error', 'It seems that you have been removed from the site.');
                    redirect(site_url("change_password/".$id));
                }
            endforeach;
        endif;
    }
    
} // class Account

/* EOF account.php */
/* Location: ./application/controllers/account.php */
