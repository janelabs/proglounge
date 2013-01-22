<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	protected $is_your_profile;
	protected $is_guest;

    function __construct()
    {
        parent::__construct();

        $this->user_session = $this->session->all_userdata();
        $this->is_logged_in = $this->mylibrary->checkUserSession($this->user_session);

        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
        $this->load->model('Post_model', 'posts');
        $this->load->model('Post_like_model', 'like');

        $this->user_info_columns = 'first_name, last_name, username, quote, about_me, image';

		//for benchmarking
        //$this->output->enable_profiler(TRUE);
    }

    public function _remap($username, $method)
    {
    	$user = $this->user->retrieveByUsername($username, 'id')->row_array();

    	if (empty($user)) {
    		show_404();
    	}

    	//check viewer of profile
    	list($this->is_your_profile, $this->is_guest) = $this->_isYourProfile($user['id']);

    	//check if the the viewer of profile already followed the user.
    	$this->is_followed = FALSE;
    	if (array_key_exists('id', $this->user_session)) {
    		$this->is_followed = $this->follow->isFollowed($this->user_session['id'], $user['id']);

            //notifications
            $notif_center = $this->notification_model->getNotificationByUser($this->user_session['id'], 5);
            $notif_all = $this->notification_model->getNotificationByUser($this->user_session['id'], 0);
            $this->data['notif_center'] = $notif_center->result_array();
            $this->data['notif_all'] = $notif_all->result_array();
            $this->data['new_notif_count'] = $this->notification_model->getNewNotificationCountByUser($this->user_session['id']);
    	}

    	/* common data */

    	if (!$this->is_guest) {
    		//suggested users to follow.
    		$suggested_ids = $this->follow->getSuggestedUserIds($this->user_session['id']);
    		list($this->data['suggested_users'],
    		     $this->data['suggested_users_count']) =
    		     $this->user->getSuggestedUsersInfo($suggested_ids, $this->user_session['id']);
    	}

        $follow_columns = 'users.id, users.username, users.image, users.first_name, users.last_name,
        follow.following_id, follow.follower_id';
        //followers
        $user_follower = $this->user->getUserFollowers($user['id'], $follow_columns);
        $this->data['follower_count'] = $user_follower->num_rows();

        //following
        $following_users = $this->user->getUserFollowing($user['id'], $follow_columns);
        $this->data['following_count'] = $following_users->num_rows();

    	$this->data['user_id'] = $user['id'];
    	$this->data['session'] = $this->user_session;

    	$this->data['is_followed'] = $this->is_followed;
    	$this->data['is_your_profile'] = $this->is_your_profile;
    	$this->data['is_guest'] = $this->is_guest;
    	/* end common data */

    	if (empty($method)) {
    		$this->index($user['id']);
    	} elseif ($method[0] == 'followers') {
    		$this->followers($user['id']);
    	} elseif ($method[0] == 'following') {
    		$this->following($user['id']);
        } elseif ($method[0] == 'load_more') {
    		$this->loadMoreUserPost($user['id']);
    	} elseif ($method[0] == 'notifications') {
            $this->notifications($user['id']);
        } else {
            show_404();
        }
    }

    public function index($id)
    {
    	//user info
    	$data['user_info'] = $this->user->retrieveById($id, $this->user_info_columns);

        //user posts
        $data['user_posts'] = $this->posts->getUserPosts($id, 10, 0);
        $data['user_posts_count'] = $this->posts->getUserPostsCount($id);

  		$data = array_merge($data, $this->data);

    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
        $data['modals'] = $this->load->view('modals_view', $data, TRUE);
        $data['profile_pic'] = $this->load->view('profile_pic_view', $data, TRUE);
    	$data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
        $data['profile_header'] = $this->load->view('profile_header_view', $data, TRUE);

    	$this->load->view('profile_view', $data);
    }

    /* display followers. */
    public function followers($id)
    {
    	$follow_columns = 'users.id, users.username, users.image, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';

    	//user info
    	$data['user_info'] = $this->user->retrieveById($id, $this->user_info_columns);

    	//followers
    	$data['user_follower'] = $this->user->getUserFollowers($id, $follow_columns);

    	//merge to common data
    	$data = array_merge($data, $this->data);

    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
        $data['profile_pic'] = $this->load->view('profile_pic_view', $data, TRUE);
    	$data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
        $data['profile_header'] = $this->load->view('profile_header_view', $data, TRUE);

    	$this->load->view('follower_view', $data);
    }

    /* display following. */
    public function following($id)
    {
    	$follow_columns = 'users.id, users.username, users.image, users.first_name, users.last_name,
    	follow.following_id, follow.follower_id';

    	//user info
    	$data['user_info'] = $this->user->retrieveById($id, $this->user_info_columns);

    	//followers
    	$data['user_following'] = $this->user->getUserFollowing($id, $follow_columns);

    	//merge to common data
    	$data = array_merge($data, $this->data);

    	//templates
    	$data['header'] = $this->load->view('header', $data, TRUE);
    	$data['footer'] = $this->load->view('footer', $data, TRUE);
        $data['profile_pic'] = $this->load->view('profile_pic_view', $data, TRUE);
    	$data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
        $data['profile_header'] = $this->load->view('profile_header_view', $data, TRUE);

    	$this->load->view('following_view', $data);
    }

    public function loadMoreUserPost($id)
    {
        $params = array();
        $params['success'] = FALSE;
        $post_id = $this->input->post('post_id', TRUE);
        $html = '';
        list($user_posts, $last_id) = $this->posts->getUserPostsByLoadMore($id, $post_id, 10, 0);
        if ($user_posts) {
            foreach ($user_posts->result('Post_like_model') as $post) {
                $dp = base_url()."public/DP/".$post->image;
                $like_count = $post->getLikersByPostId($post->id)->num_rows();
                $html .= '<div class="post-contents" style="display:none;">
                            <div class="img-username">
                              <img src="'.$dp.'"/>
                              <a href="#" class="link">'.$post->username.'</a><br>
                              <label>'.filterPostDate($post->date_created).'</label>
                            </div>
                            <blockquote class="loadmore"><p>'.filterPost($post->content).'</p></blockquote>';

               if ($this->is_your_profile) {
                   $html .= '<div class="pull-right">
                              <div class="btn-group">
                                <button class="btn btn-small">'.$like_count.' like/s.</button>
                                <button post-id="'.$post->id.'" class="delete-modal btn btn-small">
                                    &times;
                                </button>
                              </div>
                            </div>';
               } else if (!$this->is_your_profile && !$this->is_guest) {
                   if ($post->isLiked($this->user_session['id'], $post->id)) {
                       $html .= '<div class="pull-right">
                                      <div class="btn-group">
                                        <button class="btn btn-small">'.$like_count.' like/s.</button>
                                        <button class="btn btn-small btn-primary unlikebtn" post-id="'.$post->id.'"><i class="icon-thumbs-down icon-white"></i> Unlike</button>
                                      </div>
                                    </div>';
                   } else {
                       $html .= '<div class="pull-right">
                              <div class="btn-group">
                                <button class="btn btn-small">'.$like_count.' like/s.</button>
                                <button class="btn btn-small likebtn" post-id="'.$post->id.'"><i class="icon-thumbs-up"></i> Like</button>
                              </div>
                            </div>';
                   }
               } else {
                   $html .= '<div class="pull-right">
                              <div class="btn-group">
                                <button class="btn btn-small">'.$like_count.' like/s.</button>
                              </div>
                            </div>';
               }

                if ($this->is_logged_in) {
                    $comments_count = $post->getCommentsCountByPostId($post->id);
                    $page = ceil($comments_count/5);
                    $offset = getOffset($page, 5);
                    $comments = $post->getCommentsByPostId($post->id, $offset.", 3");

                    $html .= '<div class="comment-box'.$post->id.'">';
                    if ($comments_count > 3 && (($page - 1) > 0)) {
                        $html .= '<button class="show-more-comments btn-link" last-id="'.($page - 1).'">Show previous comments</button>';
                    }

                    if ($comments_count > 0) {
                        foreach ($comments->result_array() as $comment) {
                            $html .= '<div class="span7 comment_sec">';
                            $html .= '<div class="img-username-comment">';
                            $html .= '<img src="'.base_url().'public/DP/'.$comment['image'].'"/>';
                            $html .= '<a href="'.site_url($comment['username']).' class="link">'.$comment['username'].'</a><br>';
                            $html .= '<label>'.filterPostDate($comment['date_created']).'</label>';
                            $html .= '</div><blockquote><p style="font-size: 13px;">'.filterPost($comment['content']).'</p></blockquote></div>';
                        }
                    }
                    $html .= '</div>';
                    $html .= '<div class="comment-txtbox pagination-centered">
                                <input id="'.$post->id.'" type="text" class="input-block-level comment-txt" placeholder="write a comment...">
                              </div>';
                }

                $html .= '</div>';
            }
            if ($last_id != $post->id) {
                $html .= '<button class="btn btn-block btn-info" id="load-more" last-id="'.$post->id.'">load more</button>';
            }

        } else {
            echo json_encode($params);
            return;
        }

        $params['html'] = $html;
        $params['success'] = TRUE;

        echo json_encode($params);
    }

    public function notifications($id)
    {
        if (!array_key_exists('id', $this->user_session) || $id != $this->user_session['id']) {
            show_404();
        }

        //user info
        $data['user_info'] = $this->user->retrieveById($id, $this->user_info_columns);

        //get all notifications
        $data['notifs'] = $this->notification_model->getNotificationByUser($id, 0);

        //merge to common data
        $data = array_merge($data, $this->data);

        //templates
        $data['header'] = $this->load->view('header', $data, TRUE);
        $data['footer'] = $this->load->view('footer', $data, TRUE);
        $data['profile_pic'] = $this->load->view('profile_pic_view', $data, TRUE);
        $data['profile_nav'] = $this->load->view('profile_nav', $data, TRUE);
        $data['profile_header'] = $this->load->view('profile_header_view', $data, TRUE);

        $this->load->view('notification_view', $data);
    }

    /* Checks if you are viewing your profile */
    private function _isYourProfile($user_id)
    {
    	if (!array_key_exists('id', $this->user_session)) {
    		return array(FALSE, TRUE);
    	}

        // id of current user
        $sess_id = $this->user_session['id'];

    	if ($sess_id == $user_id) {
    		return array(TRUE, FALSE);
    	}

    	if ($sess_id != $user_id) {
    		return array(FALSE, FALSE);
    	}
    }

}// class Profile

/* EOF profile.php */
/* Location: ./application/controllers/profile.php */