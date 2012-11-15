<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
    }

    public function index($id = 1)
    {
    	$columns = 'users.id, users.username, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';
    	 
    	//user info
    	$data['user_info'] = $this->user->retrieveById($id, 'first_name, last_name, username');
    	 
    	//followers
    	list($data['user_follower'], 
             $data['user_follower_count']) = $this->user->getUserFollowers($id, $columns);
    	
    	//following
    	list($data['user_following'], 
             $data['user_following_count']) = $this->user->getUserFollowing($id, $columns);
    	
    	//suggested user to follow.
    	$suggested_ids = $this->follow->getSuggestedUserIds($id);
    	list($data['suggested_users'], 
             $data['suggested_users_count']) = $this->user->getSuggestedUsersInfo($suggested_ids);
    	
    	$data['user_id'] = $id;
    	
    	//templates
    	$data['header'] = $this->load->view('header', TRUE);
    	$data['footer'] = $this->load->view('footer', TRUE);
    	
    	$this->load->view('profile_view', $data);
    }

}

/* EOF profile.php */
/* Location: ./application/controllers/profile.php */