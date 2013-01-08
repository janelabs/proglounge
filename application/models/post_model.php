<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post table class
 */

Class Post_model extends CI_Model
{
	const TABLE_NAME = 'post';
	const USERS_TABLE = 'users';
	const FOLLOW_TABLE = 'follow';

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
	
	/* load more for profile */
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

    /* load more for news feed */
    public function getNewsFeedByLoadMore($user_id, $post_id, $limit, $offset = 0)
    {
        $t_follow = Follow_model::TABLE_NAME;
        $t_post = Post_model::TABLE_NAME;

        $where = array($t_follow.'.follower_id' => $user_id,
                       self::TABLE_NAME.'.id <' => $post_id);

        $on_1 = self::USERS_TABLE.'.id = '.$t_follow.'.following_id';
        $on_2 = $t_follow.'.following_id = '.$t_post.'.user_id';
        $columns = self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image, '.$t_post.'.*';

        $tmp_last_post = $this->getNewsFeedByUser($user_id, 0)->last_row('array');

        $this->db->select($columns);
        $this->db->from($t_follow);
        $this->db->join(self::USERS_TABLE, $on_1, 'join');
        $this->db->join($t_post, $on_2, 'join');
        $this->db->where($where);
        $this->db->order_by(self::TABLE_NAME.'.date_created desc');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return array($this->db->get(), $tmp_last_post['id']);
    }

    public function getNewsFeedByUser($user_id, $limit, $offset = 0)
    {
        $t_follow = Follow_model::TABLE_NAME;
        $t_post = Post_model::TABLE_NAME;

        $where = array($t_follow.'.follower_id' => $user_id);
        $on_1 = self::USERS_TABLE.'.id = '.$t_follow.'.following_id';
        $on_2 = $t_follow.'.following_id = '.$t_post.'.user_id';
        $columns = self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image, '.$t_post.'.*';

        $this->db->select($columns);
        $this->db->from($t_follow);
        $this->db->join(self::USERS_TABLE, $on_1, 'join');
        $this->db->join($t_post, $on_2, 'join');
        $this->db->where($where);
        $this->db->order_by(self::TABLE_NAME.'.date_created desc');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get();
    }

    public function getUserPostById($post_id)
    {
        $where = array('id' => $post_id);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where);

        if ($query) {
            return $query->row_array();
        } else {
            throw new Exception('Database Error');
        }
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