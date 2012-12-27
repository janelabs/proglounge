<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        //set up for uploading
        $config['upload_path'] = realpath(getcwd().'/public/DP/');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '100';
        $config['max_width'] = '500';
        $config['max_height'] = '400';

        var_dump($config);

        $this->load->library('upload', $config);
    }

    public function uploadDp()
    {

    }

}

/* EOF upload.php */
/* Location: ./application/controllers/upload.php */