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
            $data = array('user_id' => $user_id, 'message' => $msg, 'type' => 1);
            return $this->common->insertData(self::TABLE_NAME, $data);
        }

        if ($type == 2) {
            $msg = $who.self::LIKED;
            $data = array('user_id' => $user_id, 'message' => $msg, 'landing_id' => $post_id, 'type' => 2);
            return $this->common->insertData(self::TABLE_NAME, $data);
        }

        if ($type == 3) {
            $msg = $who.self::COMMENTED;
            $data = array('user_id' => $user_id, 'message' => $msg, 'landing_id' => $post_id, 'type' => 3);
            return $this->common->insertData(self::TABLE_NAME, $data);
        }
    }

    public function getNotificationByUser($user_id, $limit)
    {
        $where = array('user_id' => $user_id);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where, FALSE, 'status desc,  created_at desc', $limit);
        if ($query) {
            return $query;
        } else {
            throw new Exception('Database Error');
        }
    }

    public function getNewNotificationCountByUser($user_id)
    {
        $where = array('user_id' => $user_id, 'status' => 1);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where, FALSE, 'created_at desc');
        if ($query) {
            return $query->num_rows();
        } else {
            throw new Exception('Database Error');
        }
    }

    public function getNotificationById($notif_id)
    {
        $where = array('id' => $notif_id);
        $query = $this->common->selectWhere(self::TABLE_NAME, $where);

        if ($query) {
            return $query->row_array();
        } else {
            throw new Exception('Database Error');
        }
    }

    public function updateStatusById($notif_id)
    {
        $where = array('id' => $notif_id);
        $data = array('status' => 0);

        return $this->common->updateData(self::TABLE_NAME, $data, $where);
    }

} // Class Notification_model

/* EOF notification_model.php */
/* Location ./application/models/notification_model.php */