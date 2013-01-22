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
		return $this->common->insertData(self::TABLE_NAME, $user);
	}

    public function updateUser($user_id, $data)
    {
        $where = array('id' => $user_id);
        return $this->common->updateData(self::TABLE_NAME, $data, $where);
    }
	
	/*
	 * Checking of user if existing.
	 */
	public function checkUser($username, $password)
	{
		$where = array('username' => $username,
                       'password' => $password);
		$columns = 'id, username, image';
		
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
		$is_exists = ($query->num_rows() > 0);
		$user_info = $query->row_array();
		
		return array($is_exists, $user_info);
	}
	
	/*
	 * List all users
	 */
	public function getUsersOrderBy($order = 'id asc', $columns = FALSE, $limit = FALSE, $offset = FALSE)
	{
		$query = $this->common->retrieve(self::TABLE_NAME, $columns, $order, $limit, $offset);
		return $query;
	}
	
	public function retrieveByUsername($username, $columns)
	{
		$where = array('username' => $username);
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
		
		return $query;
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
		$on = self::FOLLOW_TABLE . '.follower_id = '.self::TABLE_NAME.'.id';
		
		$query = $this->common->selectJoin(self::TABLE_NAME, self::FOLLOW_TABLE, $on, $join_type = 'join', 
                                           $columns, $where, $order, $limit, $offset);	
		
		return $query;
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
		$on = self::FOLLOW_TABLE . '.following_id = '.self::TABLE_NAME.'.id';
		
		$query = $this->common->selectJoin(self::TABLE_NAME, self::FOLLOW_TABLE, $on, $join_type = 'join',
				                           $columns, $where, $order, $limit, $offset);
		
		return $query;
	}
	
	/*
	 * Gets suggested user info.
	 * 
	 * $ids : array of suggested user ids.
	 */
	public function getSuggestedUsersInfo($ids, $user_id)
	{
		$columns = 'id, last_name, first_name, username, image';
		$suggested_users = array();
		
		if (!is_array($ids)) {
			throw new Exception('Param must be an array.');
		}

		foreach ($ids as $id) {
			$suggested_users[] = $this->retrieveById($id, $columns);
		}
		
		return array($suggested_users, count($suggested_users));
	}

    /**
     * Get user based on the given email or username
     */
    public function getUserByUsernameEmail($options)
    {
        $query = NULL;

        if($options):
            $this->db->where($options);
            if(!$query = $this->db->get('users')->row()) $query = NULL;
        endif;

        return $query;
    }
	
} // Class Users_model

/* EOF users_model.php */
/* Location ./application/models/users_model.php */