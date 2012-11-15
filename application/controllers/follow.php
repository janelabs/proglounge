<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Follow extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        $user_session = $this->session->all_userdata();
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
    }

    public function followUser($follower_id, $following_id)
    {
        $this->follow->followUser($follower_id, $following_id);
        redirect();
    }

    public function unfollowUser($follower_id, $following_id)
    {
        $this->follow->unfollowUser($follower_id, $following_id);
        redirect();
    }

}

/* EOF follow.php */
/* Location: ./application/controllers/follow.php */