<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User table class
 */

Class Users_model extends CI_Model
{
	const TABLE_NAME = 'users';
	const FOLLOW_TABLE = 'follow';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function saveUser($user)
	{
		$this->common->insertData(self::TABLE_NAME, $user);
	}
	
	/*
	 * Checking of user if existing.
	 */
	public function checkUser($username, $password)
	{
		$where = array('username' => $username,
                       'password' => $password);
		$columns = 'id, username';
		
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
		$is_user = ($query->num_rows() > 0);
		$user_info = $query->result_array();
		
		return array($is_user, $user_info);
	}
	
	/*
	 * List all users
	 */
	public function getUsersOrderBy($order = 'id asc', $limit = FALSE, $offset = FALSE)
	{
		$query = $this->common->retrieve(self::TABLE_NAME, FALSE, $order, $limit, $offset);
		$count = $query->num_rows();
		$result = $query->result_array();
		
		return array($result, $count);
	}
	
	public function retrieveByUsername($username, $columns)
	{
		$where = array('username' => $username);
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
		
		return $query->row_array();
	}
	
	/*
	 * Gets user data using id column
	 */
	public function retrieveById($id, $columns = FALSE)
	{
		$where = array('id' => $id);
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
		
		return $query->row_array();
	}
	
	/*
	 * Gets user follower
	 * 
	 * following_id : the user
	 * follower_id  : the user's follower
	 */
	public function getUserFollowers($id, $columns = FALSE, $order = FALSE, 
			                         $limit = FALSE, $offset = FALSE)
	{
		$where = array(self::FOLLOW_TABLE . '.following_id' => $id);
		$on = self::FOLLOW_TABLE . '.follower_id = users.id'; 
		
		$query = $this->common->selectJoin(self::TABLE_NAME, self::FOLLOW_TABLE, $on, $join_type = 'join', 
                                           $columns, $where, $order, $limit, $offset);
		
		$count = $query->num_rows();
		$result = $query->result_array();
		
		return array($result, $count);
	}
	
	/*
	 * Gets user following
	 *
	 * follower_id : the user
	 * following_id  : the user's following
	 */
	public function getUserFollowing($id, $columns = FALSE, $order = FALSE, 
                                     $limit = FALSE, $offset = FALSE)
	{
		$where = array(self::FOLLOW_TABLE . '.follower_id' => $id);
		$on = self::FOLLOW_TABLE . '.following_id = users.id';
		
		$query = $this->common->selectJoin(self::TABLE_NAME, self::FOLLOW_TABLE, $on, $join_type = 'join',
				                           $columns, $where, $order, $limit, $offset);
		
		$count = $query->num_rows();
		$result = $query->result_array();
		return array($result, $count);
	}
	
	/*
	 * Gets suggested user info.
	 * 
	 * $ids : array of suggested user ids.
	 */
	public function getSuggestedUsersInfo($ids)
	{
		if (!is_array($ids)) {
			throw new Exception('Param must be an array.');
		}
		
		$suggested_users = array();
		for($i = 0; $i < count($ids); $i++) {
			$columns = 'id, last_name, first_name, username';
			$suggested_users[] = $this->retrieveById($ids[$i], $columns);
		}
		
		return array($suggested_users, count($suggested_users));
	}
	
} // Class Users_model

/* EOF users_model.php */
/* Location ./application/models/users_model.php */