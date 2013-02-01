<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->user_session = $this->session->all_userdata();
        $this->load->model('users_model', 'users');
        $this->load->model('Post_model', 'posts');
    }

    public function showNotificationInfo()
    {
        $params = array();
        $params['is_valid'] = TRUE;

        $notif_id = $this->input->post('notif_id', TRUE);

        if (!$notif_id) {
            $params['is_valid'] = FALSE;
            $params['error_msg'] = 'Invalid Request';
        }

        $notif_info = $this->notification_model->getNotificationById($notif_id);

        if (!$notif_info) {
            $params['is_valid'] = FALSE;
            $params['error_msg'] = 'Database Error';
        }

        $params['notif_info'] = $notif_info;

        //validate access
        if ($notif_info['user_id'] != $this->user_session['id']) {
            $params['is_valid'] = FALSE;
            $params['error_msg'] = 'Invalid Access';
        }

        //if follow notification
        if ($notif_info['type'] == 1) {
            $tmp_follower = explode(' ', $notif_info['message']);
            $params['the_follower'] = $tmp_follower[0];
        }

        //if like or comment notification
        if ($notif_info['type'] == 2 || $notif_info['type'] == 3) {
            $params['post_info'] = $this->posts->getUserPostById($notif_info['landing_id']);
            $params['comments'] = $this->posts->getCommentsByPostId($notif_info['landing_id'])->result_array();
            foreach ($params['comments'] as $key => $comment) {
                $params['comments'][$key]['content'] = filterPost($comment['content']);
            }
            $params['post_info']['content'] = filterPost($params['post_info']['content']);
        }

        echo json_encode($params);

        //set notif to read
        if ($notif_info['status'] == 1) {
            $this->notification_model->updateStatusById($notif_id);
        }
    }

}

/* EOF notification.php */
/* Location: ./application/controllers/notification.php */