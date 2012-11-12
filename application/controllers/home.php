<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$data['base_url'] = base_url();
		$this->load->model('users_model');
	}
	
	public function index()
	{
		list($data['users'], $data['user_count']) = $this->users_model->getUsersOrderBy();
		$this->load->view('home_view', $data);
	}
}

/* EOF home.php */
/* Location: ./application/controllers/welcome.php */