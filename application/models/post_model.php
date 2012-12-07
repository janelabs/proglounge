<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post table class
 */

Class Post_model extends CI_Model
{
	const TABLE_NAME = 'post';
	const USERS_TABLE = 'users';

	function __construct()
	{
		parent::__construct();
	}
	
	public function savePost($post)
	{
		return $this->common->insertData(self::TABLE_NAME, $post);
	}
	
	public function deletePost($post_id, $user_id = 0)
	{
	    $is_valid = $this->_validateDelete($post_id, $user_id);
		
        if (!$is_valid) {
            return FALSE;
        }
		
		$where = array('id' => $post_id);
		return $this->common->deleteDataWhere(self::TABLE_NAME, $where);
	}
	
	public function getUserPosts($user_id, $limit, $offset = 0)
	{
		$where = array(self::TABLE_NAME.'.user_id' => $user_id);
		$on = self::USERS_TABLE . '.id = '.self::TABLE_NAME.'.user_id';
		$columns = self::TABLE_NAME.'.*, '.self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image';
		$order = self::TABLE_NAME.'.id desc';
        
		return $this->common->selectJoin(self::TABLE_NAME, self::USERS_TABLE, $on, $join_type = 'join', 
                                         $columns, $where, $order, $limit, $offset);
	}

    public function getUserPostsCount($user_id)
    {
        return $this->getUserPosts($user_id, FALSE)->num_rows();
    }

    public function getUserPostsByLoadMore($user_id, $post_id, $limit, $offset = 0)
    {
        $where = array(self::TABLE_NAME.'.user_id' => $user_id,
                       self::TABLE_NAME.'.id <' => $post_id);
        $on = self::USERS_TABLE . '.id = '.self::TABLE_NAME.'.user_id';
        $columns = self::TABLE_NAME.'.*, '.self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image';
        $order = self::TABLE_NAME.'.id desc';

        $tmp_user_post = $this->getUserPosts($user_id, FALSE)->last_row('array');
        $query = $this->common->selectJoin(self::TABLE_NAME, self::USERS_TABLE, $on, $join_type = 'join',
                                           $columns, $where, $order, $limit, $offset);

        return array($query, $tmp_user_post['id']);
    }

    private function _validateDelete($post_id, $user_id)
    {
        $where = array('id' => $post_id, 'user_id' => $user_id);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where);
        $count = $query->num_rows();
        
        if ($count > 0) {
            return TRUE;
        }
        
        return FALSE;
    }
    
	
} // Class Post_model

/* EOF post_model.php */
/* Location ./application/models/post_model.php */