<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$data['base_url'] = base_url();
		$this->load->model('Users_model', 'users_model');
	}
	
	public function index()
	{
        $data['header'] = $this->load->view('header', TRUE);
        $data['footer'] = $this->load->view('footer', TRUE);

		list($data['users'], $data['user_count']) = $this->users_model->getUsersOrderBy();
		list($data['user_follower'], $data['user_follower_count']) = $this->users_model->getUserFollowers(1);
		list($data['user_following'], $data['user_following_count']) = $this->users_model->getUserFollowing(1);
		$this->load->view('home_view', $data);
	}
}

/* EOF home.php */
/* Location: ./application/controllers/welcome.php */