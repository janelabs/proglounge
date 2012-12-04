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
    
    public function saveLike($like)
    {
        return $this->common->insertData(self::TABLE_NAME, $post);
    }
    
} // Class Post_like_model

/* EOF post_like_model.php */
/* Location ./application/models/post_like_model.php */