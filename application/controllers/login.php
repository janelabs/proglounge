<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login Class
 *
 * Type: Controller
 * Author: Sarah Jane Aristain
 */

class Login extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    /**
     * Views Login page
     *
     * @access public
     * @param  void
     * @return void
     */
    public function index(){
        $this->load->view('login');
    }
}

//end of file login.php
//Location: ./proglounge/application/controllers/login.php