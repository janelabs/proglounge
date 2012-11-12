<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$data['base_url'] = base_url();
		$this->load->model('users_model');
	}
	
	public function index()
	{
		$data['users'] = $this->users_model->getUsers()->result();
		$this->load->view('welcome_message', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */