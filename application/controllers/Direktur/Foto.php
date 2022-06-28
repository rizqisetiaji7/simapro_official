<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      unset_chat_session();
      $this->load->model('project_model');
   }

   function tampil_foto() {
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['subproject_id'] == 0 ? NULL : $post['subproject_id'];
      $data['docs'] = $this->project_model->get_documentation($project_id, $subproject_id);
      $this->load->view('direktur/proyek/detail/foto_dokumentasi', $data);
   }
}