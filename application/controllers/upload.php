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

        if ( ! $this->upload->do_upload('upfile')) {
            $this->session->set_flashdata('upload_msg', $this->upload->display_errors());
            $this->session->set_flashdata('upload_status', 'error');
        } else {
            $this->session->set_flashdata('upload_msg', 'Upload Successful');
            $this->session->set_flashdata('upload_status', 'success');
            $upload_data = $this->upload->data();

            //generate thumbnail
            $thumb_filetype = explode('/', $upload_data['file_type']);
            if ($thumb_filetype[1] == 'jpeg') {
                $thumb_filetype[1] = 'jpg';
            }

            $thumb_filename = 'DP_'.$this->user_session['username'].'0';
            $thumb_filename .= $this->user_session['id'].'_thumb.'.$thumb_filetype[1];

            $config['image_library']     = 'GD2';
            $config['source_image']	     = 'public/DP/'.$upload_data['file_name'];
            $config['new_image']         = 'public/DP/'.$thumb_filename;
            $config['maintain_ratio']    = TRUE;
            $config['quality']           = '100';
            $config['width']	         = 200;
            $config['height']	         = 200;

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $data = array('image' => $upload_data['file_name'], 'image_thumb' => $thumb_filename);
            $where = array('id' => $this->user_session['id']);

            $this->common->updateData(Users_model::TABLE_NAME, $data, $where);
        }

        redirect($_SERVER['HTTP_REFERER']);

    }

}

/* EOF upload.php */
/* Location: ./application/controllers/upload.php */