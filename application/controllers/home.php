<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
    function __construct()
    {
        parent::__construct();
        
        $this->user_session = $this->session->all_userdata();
        $this->is_logged_in = $this->mylibrary->checkUserSession($this->user_session);
        
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
    }
    
    public function _remap()
    {
    	if ($this->is_logged_in) {
    		$this->index($this->user_session['id']);
    	}
    	
    	if (!$this->is_logged_in) {
    		$this->index2();
    	}
    }

    public function index()
    {
    	$id = $this->user_session['id'];
    	
        //list all users
        list($data['users'], 
             $data['user_count']) = $this->user->getUsersOrderBy();
        
        $columns = 'users.id, users.username, users.first_name, users.last_name,
                    follow.following_id, follow.follower_id';

        //followers
        list($data['user_follower'], 
             $data['user_follower_count']) = $this->user->getUserFollowers($id, $columns);

        //following
        list($data['user_following'], $data['user_following_count']) = $this->user->getUserFollowing(intval($id), $columns);
        //suggested user to follow.
        $suggested_ids = $this->follow->getSuggestedUserIds($id);
        list($data['suggested_users'], 
             $data['suggested_users_count']) = $this->user->getSuggestedUsersInfo($suggested_ids, $id);
        
        $data['user_id'] = $id;
        $data['session'] = $this->user_session;
        
        //templates
        $data['header'] = $this->load->view('header', $data, TRUE);
        $data['footer'] = $this->load->view('footer', $data, TRUE);
        
        $this->load->view('home_view', $data);
    }
    
    public function index2()
    {
    	$data['session'] = $this->user_session;
    	
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	
    	$this->load->view('home_view2', $data);
    }
    
}

/* EOF home.php */
/* Location: ./application/controllers/home.php */