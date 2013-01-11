<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
    function __construct()
    {
        parent::__construct();
        
        $this->user_session = $this->session->all_userdata();
        $this->is_logged_in = $this->mylibrary->checkUserSession($this->user_session);
        
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
        $this->load->model('Post_model', 'posts');
        $this->load->model('Post_like_model', 'post_like');
    }
    
    public function _remap($func = '')
    {
        if ($func == 'load_more_feed') {
            $this->loadMoreFeed();
            return;
        }

    	if ($this->is_logged_in) {
    		$this->index();
    	}
    	
    	if (!$this->is_logged_in) {
    		$this->index2();
    	}
    }

    public function index()
    {
    	$id = $this->user_session['id'];

        //notification
        $notif_center = $this->notification_model->getNotificationByUser($id, 5);
        $notif_all = $this->notification_model->getNotificationByUser($id, 0);

        $data['notif_center'] = $notif_center->result_array();
        $data['notif_all'] = $notif_all->result_array();
        $data['new_notif_count'] = $this->notification_model->getNewNotificationCountByUser($id);
    	
        //list all users
        $data['users'] = $this->user->getUsersOrderBy();
        $data['user_count'] = $data['users']->num_rows();
        
        $columns = 'users.id, users.username, users.first_name, users.last_name,
                    follow.following_id, follow.follower_id';

        //followers
        $data['user_follower'] = $this->user->getUserFollowers($id, $columns);
        $data['user_follower_count'] = $data['user_follower']->num_rows();

        //following
        $data['user_following'] = $this->user->getUserFollowing(intval($id), $columns);
        $data['user_following_count'] = $data['user_following']->num_rows(); 
        
        //suggested user to follow.
        $suggested_ids = $this->follow->getSuggestedUserIds($id);
        list($data['suggested_users'], 
             $data['suggested_users_count']) = $this->user->getSuggestedUsersInfo($suggested_ids, $id);
        
        $data['user_id'] = $id;
        $data['session'] = $this->user_session;

        //news feed
        $data['news_feed'] = $this->posts->getNewsFeedByUser($this->user_session['id'], Post_model::NEWS_FEED_COUNT);
        $data['news_feed_count'] = $this->posts->getNewsFeedByUser($this->user_session['id'], 0)->num_rows();
        
        //templates
        $data['header'] = $this->load->view('header', $data, TRUE);
        $data['footer'] = $this->load->view('footer', $data, TRUE);
        $data['carousel'] = $this->load->view('carousel', $data, TRUE);
        
        $this->load->view('home_view', $data);
    }

    public function loadMoreFeed()
    {
        $id = $this->user_session['id'];

        $params = array();
        $params['success'] = FALSE;
        $post_id = $this->input->post('post_id', TRUE);
        $html = '';
        list($user_posts, $last_id) = $this->posts->getNewsFeedByLoadMore($id, $post_id, 10, 0);
        if ($user_posts) {
            foreach ($user_posts->result('Post_like_model') as $post) {
                $dp = base_url()."public/DP/".$post->image;
                $like_count = $post->getLikersByPostId($post->id)->num_rows();
                $html .= '<div class="post-contents" style="width: 700px; display:none;">
                            <div class="img-username">
                              <img src="'.$dp.'"/>
                              <a href="'.site_url($post->username).'" class="link">'.$post->username.'</a><br>
                              <label>'.filterPostDate($post->date_created).'</label>
                            </div>
                            <blockquote class="loadmore"><p>'.filterPost($post->content).'</p></blockquote>';

                if ($post->isLiked($this->user_session['id'], $post->id)) {
                    $html .= '<div class="pull-right">
                                  <div class="btn-group">
                                    <button class="btn btn-small">'.$like_count.' like/s.</button>
                                    <button class="btn btn-small btn-primary unlikebtn" post-id="'.$post->id.'"><i class="icon-thumbs-down icon-white"></i> Unlike</button>
                                  </div>
                                </div>
                              </div>';
                } else {
                    $html .= '<div class="pull-right">
                          <div class="btn-group">
                            <button class="btn btn-small">'.$like_count.' like/s.</button>
                            <button class="btn btn-small likebtn" post-id="'.$post->id.'"><i class="icon-thumbs-up"></i> Like</button>
                          </div>
                        </div>
                      </div>';
                }

            }
            if ($last_id != $post->id) {
                $html .= '<button style="width: 700px;" class="btn btn-block btn-info" id="load-more-feed" last-id="'.$post->id.'">load more</button>';
            }

        } else {
            echo json_encode($params);
            return;
        }

        $params['html'] = $html;
        $params['success'] = TRUE;

        echo json_encode($params);
    }
    
    public function index2()
    {
    	$data['session'] = $this->user_session;
    	
    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
    	$data['carousel'] = $this->load->view('carousel', $data, TRUE);
    	
    	$this->load->view('home_view2', $data);
    }
    
}

/* EOF home.php */
/* Location: ./application/controllers/home.php */