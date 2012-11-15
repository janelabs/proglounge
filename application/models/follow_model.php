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
		
		if ($this->_isFollowed($follower_id, $following_id)) {
			throw new Exception('Already followed the user');
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
	
	public function getSuggestedUserIds($follower_id)
	{
		$tmp_suggested_ids1 = array();
		$tmp_suggested_ids2 = array();
		
		//users followed by the current user.
		$user_following_ids = $this->_getUserFollowingIds($follower_id);
		
		foreach ($user_following_ids as $user_following_id) {
			//users followed by the current user's following.
			$following_ids = $this->_getUserFollowingIds($user_following_id['following_id']);
			foreach ($following_ids as $following_id) {
				$is_you = ($following_id['following_id'] == $follower_id);
				$is_followed = $this->_isFollowed($follower_id, $following_id['following_id']);
				$in_array = (in_array($following_id['following_id'], $tmp_suggested_ids2));
				
				if (!$is_you && !$is_followed && !$in_array) {
					$tmp_suggested_ids1[] = $following_id['following_id'];
				}
			}
		}
		
		//follower of user.
		$user_follower_ids = $this->_getUserFollowerIds($follower_id);
		
		foreach ($user_follower_ids as $user_follower_id) {
			//users followed by the current user's follower.
			$follower_following_ids = $this->_getUserFollowingIds($user_follower_id['follower_id']);
			foreach ($follower_following_ids as $follower_following_id) {
				$is_you = ($follower_following_id['following_id'] == $follower_id);
				$is_followed = $this->_isFollowed($follower_id, $follower_following_id['following_id']);
				$in_array = (in_array($follower_following_id['following_id'], $tmp_suggested_ids2));
				
				if (!$is_you && !$in_array && !$is_followed) {
					$tmp_suggested_ids2[] = $follower_following_id['following_id'];
				}
			}
		}
		
		return array_merge($tmp_suggested_ids1 += $tmp_suggested_ids2);
		
	}
	
	private function _getUserFollowingIds($follower_id)
	{
		$where = array('follower_id' => $follower_id);
		$columns = 'following_id';
		
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
		
		return $query->result_array();
	}
	
	private function _getUserFollowerIds($following_id)
	{
		$where = array('following_id' => $following_id);
		$columns = 'follower_id';
	
		$query = $this->common->selectWhere(self::TABLE_NAME, $where, $columns);
	
		return $query->result_array();
	}
	
	private function _isFollowed($follower_id, $following_id)
	{
		$where = array('follower_id' => $follower_id,
                       'following_id' => $following_id);
		
		$query = $this->common->selectWhere(self::TABLE_NAME, $where);
		if ($query->num_rows() > 0) {
			return TRUE;
		}
		
		return FALSE;
	}
		
} // Class Follow_model

/* EOF follow_model.php */
/* Location ./application/models/follow_model.php */