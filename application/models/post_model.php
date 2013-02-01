<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post table class
 */
require_once('post_like_model.php');

Class Post_model extends Post_like_model
{
	const TABLE_NAME = 'post';
	const USERS_TABLE = 'users';
	const FOLLOW_TABLE = 'follow';
    const NEWS_FEED_COUNT = 10;

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

        //delete notification, likes, comments
        $this->common->deleteDataWhere(Post_comment_model::TABLE_NAME, array('post_id' => $post_id));
        $this->common->deleteDataWhere(Post_like_model::TABLE_NAME, array('post_id' => $post_id));
        $this->common->deleteDataWhere(Notification_model::TABLE_NAME, array('landing_id' => $post_id, 'type >' => 1));

		return $this->common->deleteDataWhere(self::TABLE_NAME, $where);
	}
	
	public function getUserPosts($user_id, $limit, $offset = 0)
	{
		$where = array(self::TABLE_NAME.'.user_id' => $user_id);
		$on = self::USERS_TABLE . '.id = '.self::TABLE_NAME.'.user_id';
		$columns = self::TABLE_NAME.'.*, '.self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image, '.self::USERS_TABLE.'.image_thumb';
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
        $columns = self::TABLE_NAME.'.*, '.self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image, '.self::USERS_TABLE.'.image_thumb';
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
        $t_post = self::TABLE_NAME;
        $t_users = self::USERS_TABLE;

        $sql_query = "SELECT DISTINCT {$t_users}.username, {$t_users}.image, {$t_users}.image_thumb,  post.*
                      FROM ( {$t_follow} LEFT JOIN {$t_users} ON {$t_users}.id = {$t_follow}.following_id )
                      LEFT JOIN {$t_post} ON {$t_follow}.following_id = post.user_id
                      WHERE ( {$t_follow}.follower_id = {$user_id} AND {$t_post}.id < {$post_id} )
                      OR ( {$t_post}.user_id = {$user_id} AND {$t_post}.id < {$post_id} )
                      ORDER BY {$t_post}.date_created DESC limit {$limit}";

        $tmp_last_post = $this->getNewsFeedByUser($user_id, 0)->last_row('array');
        $query = $this->db->query($sql_query);

        return array($query, $tmp_last_post['id']);
    }

    public function getNewsFeedByUser($user_id, $limit, $offset = 0)
    {
        $t_follow = Follow_model::TABLE_NAME;
        $t_post = Post_model::TABLE_NAME;

        $where = array($t_follow.'.follower_id' => $user_id);
        $where2 = array($t_post.'.user_id' => $user_id);
        $on_1 = self::USERS_TABLE.'.id = '.$t_follow.'.following_id';
        $on_2 = $t_follow.'.following_id = '.$t_post.'.user_id';
        $columns = self::USERS_TABLE.'.username, '.self::USERS_TABLE.'.image, '.self::USERS_TABLE.'.image_thumb, '.$t_post.'.*';

        $this->db->select($columns);
        $this->db->from($t_follow);
        $this->db->join(self::USERS_TABLE, $on_1, 'join');
        $this->db->join($t_post, $on_2, 'join');
        $this->db->where($where);
        $this->db->or_where($where2);
        $this->db->order_by(self::TABLE_NAME.'.date_created desc');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->distinct();

        return $this->db->get();
    }

    public function getUserPostById($post_id)
    {
        $where = array('id' => $post_id);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where);

        return $query->row_array();
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