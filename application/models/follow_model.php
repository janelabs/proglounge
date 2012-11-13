<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Follow table class
 */

Class Follow_model extends CI_Model
{
	const TABLE_NAME = 'follow';
	const USERS_TABLE = 'users';
	
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * Follow me!
	 * 
	 * $follower_id  : user.id
	 * $following_id : other user.id
	 */
	public function followUser($follower_id, $following_id)
	{
		if (empty($follower_id) || empty($following_id)) {
			throw new Exception('empty parameter');
		}
		
		$follow = array('follower_id'  => $follower_id,
                        'following_id' => $following_id);
		
		$this->common->insertData(self::TABLE_NAME, $follow);
	}
	
	/*
	 * Unfollow me!
	 * 
	 * $follower_id  : user.id
	 * $following_id : other user.id
	 */
	public function unfollowUser($follower_id, $following_id)
	{
		if (empty($follower_id) || empty($following_id)) {
			throw new Exception('empty parameter');
		}
		
		$unfollow = array('follower_id'  => $follower_id,
                          'following_id' => $following_id);
		
		$this->common->deleteDataWhere(self::TABLE_NAME, $unfollow);
	}
		
} // Class Follow_model

/* EOF follow_model.php */
/* Location ./application/models/follow_model.php */