<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->user_session = $this->session->all_userdata();
        $this->is_logged_in = $this->mylibrary->checkUserSession($this->user_session);
        
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
        $this->load->model('Post_model', 'posts');
        $this->load->model('Post_like_model', 'like');
        $this->load->model('Post_comment_model', 'comment');
    }

    public function newPost()
    {
        $params = array();
        $post = $this->input->post(NULL, TRUE);
        $post['user_id'] = $this->user_session['id'];
        $params['is_error'] = TRUE;
         
        if (!$this->posts->savePost($post)) {
            echo json_encode($params);
            return;
        }
        
        $params['is_error'] = FALSE;
        $params['content'] = filterPost($post['content']);
        $params['username'] = $this->user_session['username'];
        $now = date("Y-m-d H:i:s");
        $params['postdate'] = filterPostDate($now);
        $params['post_id'] = $this->db->insert_id();
        $params['user_image'] = base_url()."public/DP/".$this->user_session['image'];
        
        echo json_encode($params);
    }
    
    public function deletePost()
    {
        $params = array();
        $params['success'] = FALSE;
        $post_id = $this->input->post('post_id', TRUE);
        $user_id = $this->user_session['id'];
        
        if ($this->posts->deletePost($post_id, $user_id)) {
            $params['success'] = TRUE;
            echo json_encode($params);
            return;
        }
        
        echo json_encode($params);
        
    }

    public function likePost()
    {
        $post_id = $this->input->post('post_id', TRUE);
        $this->like->likePost($this->user_session['id'], $post_id);
    }

    public function unlikePost()
    {
        $post_id = $this->input->post('post_id', TRUE);
        $this->like->unlikePost($this->user_session['id'], $post_id);
    }

    public function newComment()
    {
        $params = array();
        $comment = $this->input->post(NULL, TRUE);
        $comment['user_id'] = $this->user_session['id'];
        $params['is_error'] = TRUE;

        if (!$this->comment->addNewComment($comment)) {
            echo json_encode($params);
            return;
        }

        $params['is_error'] = FALSE;
        $params['content'] = filterPost($comment['content']);
        $params['username'] = $this->user_session['username'];
        $now = date("Y-m-d H:i:s");
        $params['commentdate'] = filterPostDate($now);
        $params['comment_id'] = $this->db->insert_id();
        $params['user_image'] = base_url()."public/DP/".$this->user_session['image'];

        echo json_encode($params);
    }

    public function showMoreComment()
    {
        $params = array();
        $params['success'] = TRUE;
        $last_id = $this->input->post('comment_id', TRUE);
        $post_id = $this->input->post('post_id', TRUE);
        $html = '';

        list($comments, $last_comment_id) = $this->comment->getCommentsByLoadMore($post_id, $last_id, 3);

        if (!$comments || !$last_comment_id) {
            $params['success'] = FALSE;
            echo json_encode($params);
            return;
        }

        $last_id_for_button = $comments->last_row()->id;

        if ($last_id_for_button != $last_comment_id) {
            $html .= '<button href="#" class="show-more-comments btn-link" last-id="'.$last_id_for_button.'" class="pull-right btn-link">Show previous comments</button>';
        }
        $comments = array_reverse($comments->result_array());
        foreach ($comments as $comment) {
            $html .= '<div class="span7 comment_sec" style="display: none;">
                         <div class="img-username-comment">
                             <img src="'.base_url()."public/DP/".$comment['image'].'"/>
                             <a href="'.site_url($comment['username']).'" class="link">'.$comment['username'].'</a><br>
                             <label>'.filterPostDate($comment['date_created']).'</label>
                         </div>
                         <blockquote class="new-comment">
                             <p style="font-size: 13px;">'.filterPost($comment['content']).'</p>
                         </blockquote>
                     </div>';
        }

        $params['html'] = $html;

        echo json_encode($params);
    }

}// class Posts

/* EOF posts.php */
/* Location: ./application/controllers/posts.php */