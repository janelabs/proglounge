<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model', 'user');
        $this->load->model('Follow_model', 'follow');
    }

    public function index()
    {
        //list all users
        list($data['users'], $data['user_count']) = $this->user->getUsersOrderBy();

        //followers
        list($data['user_follower'], $data['user_follower_count']) = $this->user->getUserFollowers(1);

        //following
        list($data['user_following'], $data['user_following_count']) = $this->user->getUserFollowing(1);

        $data['header'] = $this->load->view('header', TRUE);
        $data['footer'] = $this->load->view('footer', TRUE);
        $this->load->view('home_view', $data);
    }

    public function follow($following_id)
    {
        $this->follow->followUser(1, $following_id);
        redirect();
    }

    public function unfollow($following_id)
    {
        $this->follow->unfollowUser(1, $following_id);
        redirect();
    }

    /**
     * Views registration form
     *
     * @access public
     * @param void
     * @return void
     */
    public function register(){
        $data['header'] = $this->load->view('header', TRUE);
        $data['footer'] = $this->load->view('footer', TRUE);

        $this->load->view('register', $data);
    }
}

/* EOF home.php */
/* Location: ./application/controllers/welcome.php */