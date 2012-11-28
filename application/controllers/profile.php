<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	protected $is_your_profile;
	protected $is_guest;
	
    function __construct()
    {
        parent::__construct();
        
        $this->user_session = $this->session->all_userdata();
        $this->is_logged_in = $this->mylibrary->checkUserSession($this->user_session);
        
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
        
		//for benchmarking
        $this->output->enable_profiler(TRUE);
    }
    
    public function _remap($username, $method)
    {
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
    	
    	//check if the the viewer of profile already followed the user.
    	$this->is_followed = FALSE;
    	if (array_key_exists('id', $this->user_session)) {
    		$this->is_followed = $this->follow->isFollowed($this->user_session['id'], $user['id']);
    	}
    	
    	/* common data */
    	if (!$this->is_guest) {
    		//suggested users to follow.
    		$suggested_ids = $this->follow->getSuggestedUserIds($this->user_session['id']);
    		list($this->data['suggested_users'],
    		     $this->data['suggested_users_count']) =
    		     $this->user->getSuggestedUsersInfo($suggested_ids, $this->user_session['id']);
    	}
    	 
    	$this->data['user_id'] = $user['id'];
    	$this->data['session'] = $this->user_session;
    	
    	$this->data['is_followed'] = $this->is_followed;
    	$this->data['is_your_profile'] = $this->is_your_profile;
    	$this->data['is_guest'] = $this->is_guest;
    	/* end common data */
    	
    	if (empty($method)) {
    		$this->index($user['id']);
    	} elseif ($method[0] == 'followers') {
    		$this->followers($user['id']);
    	} elseif ($method[0] == 'following') {
    		$this->following($user['id']);
    	}
    }

    public function index($id)
    {	 
    	//user info
    	$user_info_columns = 'first_name, last_name, username, quote, about_me';
    	$data['user_info'] = $this->user->retrieveById($id, $user_info_columns);

    	$follow_columns = 'users.id, users.username, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';
    	//followers
    	$data['user_follower'] = $this->user->getUserFollowers($id, $follow_columns);
        $data['user_follower_count'] = $data['user_follower']->num_rows();
    	
    	//following
    	$following_users = $this->user->getUserFollowing($id, $follow_columns);
        $data['user_following_count'] = $following_users->num_rows();
    	
  		$data = array_merge($data, $this->data);
        
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	$data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
    	
    	$this->load->view('profile_view', $data);   	
    }
    
    /* display of followers. */
    public function followers($id) 
    {
    	$follow_columns = 'users.id, users.username, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';
    	
    	//user info
    	$user_info_columns = 'first_name, last_name, username, quote, about_me';
    	$data['user_info'] = $this->user->retrieveById($id, $user_info_columns);
    	
    	//followers
    	$data['user_follower'] = $this->user->getUserFollowers($id, $follow_columns);
    	$data['user_follower_count'] = $data['user_follower']->num_rows();
    	
    	//merge to common data
    	$data = array_merge($data, $this->data);
    	
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	$data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
    	
    	$this->load->view('follower_view', $data);
    }
    
    /* display of following. */
    public function following($id)
    {
    	$follow_columns = 'users.id, users.username, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';
    	
    	//user info
    	$user_info_columns = 'first_name, last_name, username, quote, about_me';
    	$data['user_info'] = $this->user->retrieveById($id, $user_info_columns);
    	
    	//followers
    	$data['user_follower'] = $this->user->getUserFollowers($id, $follow_columns);
    	$data['user_follower_count'] = $data['user_follower']->num_rows();
    	
    	//merge to common data
    	$data = array_merge($data, $this->data);
    	 
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	$data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
    	
    	$this->load->view('following_view', $data);
    }
       
    /* Checks if you are viewing your profile */
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