<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User table class
 */

Class Users_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'users';
	}
	
	/*
	 * Save users using array
	 */
	public function saveUser($user)
	{
		if (is_array($user)) {
			$this->db->insert($this->table, $user);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/*
	 * Get users dynamically
	 */
	public function getUsers($orderby = FALSE, $limit = FALSE, $offset = FALSE)
	{
		if ($orderby) {
			$orderby = explode('-', $orderby);
			$this->db->order_by($orderby[0], $orderby[1]);
		}
		
		if ($limit && $offset) {
			$this->db->limit($limit, $offset);
		}
		
		$users = $this->db->get($this->table);
		
		return $users;
	}
	
	public function getName($id)
	{
		return $this->common_model->retrieveById($id);
	}
	
} // Class Users_model

/* EOF users_model.php */