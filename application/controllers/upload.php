<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->user_session = $this->session->all_userdata();

        //set up for uploading
        $config['upload_path'] = 'public/DP/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = TRUE;
        $config['file_name'] = 'DP_'.$this->user_session['username'].'0'.$this->user_session['id'];

        $this->load->library('upload', $config);
        $this->load->model('Users_model', 'user');
    }

    public function uploadDp()
    {
        if (!array_key_exists('id', $this->user_session)) {
            throw new Exception('Invalid Access');
        }

        if ( ! $this->upload->do_upload('upfile'))
        {
            $this->session->set_flashdata('upload_msg', $this->upload->display_errors());
            $this->session->set_flashdata('upload_status', 'error');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('upload_msg', 'Upload Successful');
            $this->session->set_flashdata('upload_status', 'success');
            $upload_data = $this->upload->data();

            $data = array('image' => $upload_data['file_name']);
            $where = array('id' => $this->user_session['id']);

            $this->common->updateData(Users_model::TABLE_NAME, $data, $where);
            
            //change image session
            $this->session->set_userdata('image', $upload_data['file_name']);
            
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}

/* EOF upload.php */
/* Location: ./application/controllers/upload.php */