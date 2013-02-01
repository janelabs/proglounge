<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post_comment table class
 */
Class Post_comment_model extends CI_Model
{
    const TABLE_NAME = 'post_comments';
    const USERS_TABLE = 'users';

    function __construct()
    {
        parent::__construct();
    }

    public function addNewComment($comment)
    {
        $query = $this->common->insertData(self::TABLE_NAME, $comment);

        //insert notification
        $query2 = $this->common->selectWhere(self::TABLE_NAME, array('post_id' => $comment['post_id']), 'user_id');
        foreach ($query2->result_array() as $c) {
            $this->notification_model->addNotification($c['user_id'], $comment['user_id'], 3, $comment['post_id']);
        }

        return $query;
    }

    public function deleteComment($comment_id, $user_id = 0)
    {
        $is_valid = $this->_validateDelete($comment_id, $user_id);

        if (!$is_valid) {
            return FALSE;
        }

        $where = array('id' => $comment_id);
        return $this->common->deleteDataWhere(self::TABLE_NAME, $where);
    }

    public function getCommentsByPostId($post_id, $limit = "")
    {
        if (!$post_id) {
            throw new Exception('empty parameter');
        }

        if ($limit != "") {
            $limit = "LIMIT {$limit}";
        }

        $sql_query = "SELECT pc.*, u.username, u.image, u.image_thumb
                      FROM ".self::TABLE_NAME." pc
                      INNER JOIN ".self::USERS_TABLE." u ON u.id = pc.user_id
                      WHERE pc.post_id = {$post_id} order by pc.id asc {$limit}";

        $query = $this->db->query($sql_query);

        return $query;
    }

    public function getCommentsCountByPostId($post_id)
    {
        return $this->getCommentsByPostId($post_id)->num_rows();
    }

    /* load more for comments */
    public function getCommentsByLoadMore($post_id, $last_id, $limit = "")
    {
        if ($limit != "") {
            $limit = "LIMIT {$limit}";
        }

        $sql_query = "SELECT pc.*, u.username, u.image, u.image_thumb
                      FROM ".self::TABLE_NAME." pc
                      INNER JOIN ".self::USERS_TABLE." u ON u.id = pc.user_id
                      WHERE pc.post_id = {$post_id} and pc.id < {$last_id} order by pc.id desc {$limit}";

        $tmp_last_comment = $this->getCommentsByPostId($post_id)->first_row()->id;

        $query = $this->db->query($sql_query);

        return array($query, $tmp_last_comment);
    }

    private function _validateDelete($comment_id, $user_id)
    {
        if (!$comment_id || !$user_id) {
            throw new Exception('Empty parameter');
        }

        $where = array('id' => $comment_id, 'user_id' => $user_id);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where);
        $count = $query->num_rows();

        if ($count > 0) {
            return TRUE;
        }

        return FALSE;
    }

} // Class Post_comment_model

/* EOF post_comment_model.php */
/* Location ./application/models/post_comment_model.php */