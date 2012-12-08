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

    public function loadMoreUserPost()
    {
        $params = array();
        $params['success'] = FALSE;
        $post_id = $this->input->post('post_id', TRUE);
        $user_id = $this->user_session['id'];
        $html = '';

        list($user_posts, $last_id) = $this->posts->getUserPostsByLoadMore($user_id, $post_id, 10, 0);

        if ($user_posts) {
            foreach ($user_posts->result_array() as $post) {
                $html .= '<div class="post-contents" style="display:none;">
                            <div class="img-username">
                              <img src="http://placehold.it/35x35"/>
                              <a href="#" class="link">'.$post['username'].'</a><br>
                              <label>'.filterPostDate($post['date_created']).'</label>
                            </div>
                            <blockquote class="loadmore"><p>'.filterPost($post['content']).'</p></blockquote>
                            <div class="pull-right">
                              <div class="btn-group">
                                <button post-id="'.$post['id'].'" class="delete-modal btn btn-danger btn-mini">
                                  <i class="icon-trash icon-white"></i>
                                </button>
                              </div>
                            </div>
                          </div>';
            }
            if ($last_id != $post['id']) {
                $html .= '<button class="btn btn-block btn-info" id="load-more" last-id="'.$post['id'].'">load more</button>';
            }

        } else {
            echo json_encode($params);
            return;
        }

        $params['html'] = $html;
        $params['success'] = TRUE;

        echo json_encode($params);
    }

}// class Posts

/* EOF posts.php */
/* Location: ./application/controllers/posts.php */