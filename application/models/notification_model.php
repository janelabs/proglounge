<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Notification table class
 */

Class Notification_model extends CI_Model
{
    const TABLE_NAME = 'notification';

    //constant notification message.
    const FOLLOWED  = ' started following you.';
    const LIKED     = ' liked your post.';
    const COMMENTED = ' commented on your post';

    function __construct()
    {
        parent::__construct();
    }

    public function addNotification($user_id, $who_id, $type, $post_id = FALSE)
    {
        $query = $this->common->selectWhere(Users_model::TABLE_NAME, array('id' => $who_id), 'username');
        $who = $query->row()->username;

        if ($type == 1) {
            $msg = $who.self::FOLLOWED;
            $data = array('user_id' => $user_id, 'message' => $msg);
            return $this->common->insertData(self::TABLE_NAME, $data);
        }

        if ($type == 2) {
            $msg = $who.self::LIKED;
            $data = array('user_id' => $user_id, 'message' => $msg, 'landing_id' => $post_id);
            return $this->common->insertData(self::TABLE_NAME, $data);
        }

        if ($type == 3) {
            $msg = $who.self::COMMENTED;
            $data = array('user_id' => $user_id, 'message' => $msg, 'landing_id' => $post_id);
            return $this->common->insertData(self::TABLE_NAME, $data);
        }
    }

} // Class Notification_model

/* EOF notification_model.php */
/* Location ./application/models/notification_model.php */