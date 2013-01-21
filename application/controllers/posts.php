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
        $html2 = '';

        list($comments, $last_comment_id) = $this->comment->getCommentsByLoadMore($post_id, $last_id, 5);

        if (!$comments) {
            $params['success'] = FALSE;
            echo json_encode($params);
            return;
        }

        foreach ($comments->result_array() as $comment) {
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

        $html2 .= '<div class="comment-txtbox">';
        $html2 .= '<input id="'.$post_id.'" type="text" class="input-block-level comment-txt" placeholder="write a comment...">';

        log_message('info', $comment['id']);
        log_message('info', $last_comment_id);

        if ($last_comment_id != $comment['id']) {
            $html2 .= '<a href="#" class="show-more-comments" last-id="'.$comment['id'].'" class="pull-right btn-link">Show more comments</a>';
        }

        $html2 .= '</div>';

        $params['html'] = $html;
        $params['html2'] = $html2;

        echo json_encode($params);
    }

}// class Posts

/* EOF posts.php */
/* Location: ./application/controllers/posts.php */