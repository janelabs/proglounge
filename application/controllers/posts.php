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
    }
    
    /*
     *  saves user's post
     */
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

}// class Posts

/* EOF posts.php */
/* Location: ./application/controllers/posts.php */