<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Post_like table class
 */

Class Post_like_model extends CI_Model
{
    const TABLE_NAME = 'post_like';
    const USERS_TABLE = 'users';

    function __construct()
    {
        parent::__construct();
    }

    public function likePost($liker_user_id, $post_id)
    {
        if (empty($liker_user_id) || empty($post_id)) {
            throw new Exception('empty parameter/s');
        }

        if ($this->isLiked($liker_user_id, $post_id)) {
            throw new Exception('Already liked the post');
        }

        $like = array('user_id' => $liker_user_id,
                      'post_id' => $post_id);

        $this->common->insertData(self::TABLE_NAME, $like);

        $query = $this->common->selectWhere(Post_model::TABLE_NAME, array('id' => $post_id), 'user_id');
        $user_id = $query->row()->user_id;

        $this->notification_model->addNotification($user_id, $liker_user_id, 2, $post_id);
    }

    public function unlikePost($liker_user_id, $post_id)
    {
        if (empty($liker_user_id) || empty($post_id)) {
            throw new Exception('empty parameter');
        }

        $unlike = array('user_id'  => $liker_user_id,
                        'post_id' => $post_id);

        $this->common->deleteDataWhere(self::TABLE_NAME, $unlike);
    }

    public function getLikersByPostId($post_id)
    {
        if (empty($post_id)) {
            throw new Exception('empty parameter');
        }

        $where = array('post_id' => $post_id);

        $query = $this->common->selectWhere(self::TABLE_NAME, $where);

        if ($query) {
            return $query;
        } else {
            throw new Exception('Databse Error');
        }
    }

    public function isLiked($liker_user_id, $post_id)
    {
        $where = array('user_id' => $liker_user_id,
                       'post_id' => $post_id);

        $query = $this->common->selectWhere(self::TABLE_NAME, $where);
        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }
    
} // Class Post_like_model

/* EOF post_like_model.php */
/* Location ./application/models/post_like_model.php */