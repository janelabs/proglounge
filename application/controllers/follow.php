<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Follow extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->user_session = $this->session->all_userdata();
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
    }

    public function followUser()
    {
    	$following_id = $this->input->post('id', TRUE);
        $this->follow->followUser($this->user_session['id'], $following_id);
    }

    public function unfollowUser($following_id)
    {
        $this->follow->unfollowUser($this->user_session['id'], $following_id);
    }

}

/* EOF follow.php */
/* Location: ./application/controllers/follow.php */