<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {
	
    function __construct()
    {
        parent::__construct();
    }
    
    public function pageMissing()
    {
    	show_404();
    }
    
}

/* EOF error.php */
/* Location: ./application/controllers/error.php */