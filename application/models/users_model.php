<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User table class
 */

Class Users_model extends CI_Model
{
	const TABLE_NAME = 'users';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function saveUser($user)
	{
		$this->common->insertData(self::TABLE_NAME, $user);
	}
	
	public function getUsersOrderBy($order = 'id asc', $limit = FALSE, $offset = FALSE)
	{
		$query = $this->common->retrieve(self::TABLE_NAME, FALSE, $order, $limit, $offset);
		$count = $this->common->getQueryResult($query, 'num_rows');
		$result = $this->common->getQueryResult($query, 'result_array');
		
		return array($result, $count);
	}
	
	public function retrieveById($id)
	{
		$where = array('id' => $id);
		$query = $this->common->selectWhere(self::TABLE_NAME, $where);
		
		return $this->common->getQueryResult($query, 'result_array');
	}
	
} // Class Users_model

/* EOF users_model.php */
/* Location ./application/models/users_model.php */