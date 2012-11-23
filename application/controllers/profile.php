<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	var $is_your_profile = FALSE;
	var $is_guest = FALSE;
	
    function __construct()
    {
        parent::__construct();
        
        $this->user_session = $this->session->all_userdata();
        $this->is_logged_in = $this->mylibrary->checkUserSession($this->user_session);
        
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
        
        $this->output->enable_profiler(TRUE);
    }
    
    public function _remap($username, $method)
    {
   	
    	if (empty($method)) {
    		$user = $this->user->retrieveByUsername($username, 'id');
    		if (empty($user)) {
    			show_404();
    		}
    		
    		//check viewer of profile
    		if (array_key_exists('id', $this->user_session)) {
    			list($this->is_your_profile,
    				 $this->is_guest) = $this->_isYourProfile($this->user_session['id'], $user['id']);
    		} else {
    			list($this->is_your_profile,
    				 $this->is_guest) = $this->_isYourProfile('guest', $user['id']);
    		}
    		
    		$this->index($user['id']);
    		   		
    	}
    }

    public function index($id)
    {
    	$columns = 'users.id, users.username, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';
    	 
    	//user info
    	$data['user_info'] = $this->user->retrieveById($id, 'first_name, last_name, username, bio, about_me');
    	 
    	//followers
    	list($data['user_follower'], 
             $data['user_follower_count']) = $this->user->getUserFollowers($id, $columns);
    	
    	//following
    	list($data['user_following'], 
             $data['user_following_count']) = $this->user->getUserFollowing($id, $columns);
    	
  		if (!$this->is_guest) {
	    	//suggested user to follow.
	    	$suggested_ids = $this->follow->getSuggestedUserIds($id);
	    	list($data['suggested_users'], 
	             $data['suggested_users_count']) = 
	    	     $this->user->getSuggestedUsersInfo($suggested_ids, $this->user_session['id']);
  		}
    	
    	$data['user_id'] = $id;
    	$data['session'] = $this->user_session;

        $data['is_your_profile'] = $this->is_your_profile; 
    	$data['is_guest'] = $this->is_guest;
    	
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	
    	if ($this->is_guest === TRUE) {
    		$this->load->view('profile_guest_view', $data);
    	} else {
    		$this->load->view('profile_view', $data);
    	}
    	
    }
       
    /*
     * Checks if you are viewing your profile
     */
    private function _isYourProfile($sess_id, $id)
    {
    	if ($sess_id == 'guest') {
    		return array(FALSE, TRUE);
    	}
    
    	if ($sess_id == $id) {
    		return array(TRUE, FALSE);
    	}
    
    	if ($sess_id != $id) {
    		return array(FALSE, FALSE);
    	}
    }

}// class Profile

/* EOF profile.php */
/* Location: ./application/controllers/profile.php */