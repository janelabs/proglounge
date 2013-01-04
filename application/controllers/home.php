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

        //notification
        $notif_center = $this->notification_model->getNotificationByUser($id, 5);
        $notif_all = $this->notification_model->getNotificationByUser($id, 0);

        $data['notif_center'] = $notif_center->result_array();
        $data['notif_all'] = $notif_all->result_array();
        $data['new_notif_count'] = $this->notification_model->getNewNotificationCountByUser($id);
    	
        //list all users
        $data['users'] = $this->user->getUsersOrderBy();
        $data['user_count'] = $data['users']->num_rows();
        
        $columns = 'users.id, users.username, users.first_name, users.last_name,
                    follow.following_id, follow.follower_id';

        //followers
        $data['user_follower'] = $this->user->getUserFollowers($id, $columns);
        $data['user_follower_count'] = $data['user_follower']->num_rows();

        //following
        $data['user_following'] = $this->user->getUserFollowing(intval($id), $columns);
        $data['user_following_count'] = $data['user_following']->num_rows(); 
        
        //suggested user to follow.
        $suggested_ids = $this->follow->getSuggestedUserIds($id);
        list($data['suggested_users'], 
             $data['suggested_users_count']) = $this->user->getSuggestedUsersInfo($suggested_ids, $id);
        
        $data['user_id'] = $id;
        $data['session'] = $this->user_session;
        
        //templates
        $data['header'] = $this->load->view('header', $data, TRUE);
        $data['footer'] = $this->load->view('footer', $data, TRUE);
        $data['carousel'] = $this->load->view('carousel', $data, TRUE);
        
        $this->load->view('home_view', $data);
    }
    
    public function index2()
    {
    	$data['session'] = $this->user_session;
    	
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	$data['carousel'] = $this->load->view('carousel', $data, TRUE);
    	
    	$this->load->view('home_view2', $data);
    }
    
}

/* EOF home.php */
/* Location: ./application/controllers/home.php */