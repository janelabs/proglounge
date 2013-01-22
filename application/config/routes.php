<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = 'error/pageMissing';

//follow
$route['follow'] = 'follow/followUser';
$route['unfollow'] = 'follow/unfollowUser';

//home
$route['load_more_feed'] = 'home/load_more_feed';

//notification
$route['show_notif'] = 'notification/showNotificationInfo';

//account
$route['login'] = 'account/login';
$route['update'] = 'account/updateUser';
$route['validate'] = 'account/checkLogin';
$route['recover_password'] = 'account/password_recovery';
$route['save_user'] = 'account/saveUser';
$route['check_uname'] = 'account/checkUname';
$route['logout'] = 'account/logout';
$route['register'] = 'account/register';
$route['account'] = 'error/pageMissing';
$route['account/(:any)'] = 'error/pageMissing';

//posts
$route['like'] = 'posts/likePost';
$route['unlike'] = 'posts/unlikePost';
$route['new_post'] = 'posts/newPost';
$route['delete_post'] = 'posts/deletePost';
$route['new_comment'] = 'posts/newComment';
$route['show_more_comment'] = 'posts/showMoreComment';
$route['load_more'] = 'posts/loadMoreUserPost';

//upload
$route['upload'] = 'upload/uploadDp';

//profile
$route['profile'] = 'error/pageMissing';
$route['profile/(:any)'] = 'error/pageMissing';
$route['(:any)/load_more'] = 'profile/$1/load_more';
$route['(:any)/followers'] = 'profile/$1/followers';
$route['(:any)/following'] = 'profile/$1/following';
$route['(:any)'] = 'profile/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */