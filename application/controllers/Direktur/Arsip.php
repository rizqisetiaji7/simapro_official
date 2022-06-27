<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
   private $tb_project = 'tb_project';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }

   protected function _tampil_arsip($limit) {
      $company_id = user_company()->company_id;
      return $this->project_model->get_project_archive($company_id, $limit)->result();
   }

   protected function _detail_proyek($company_id, $project_code) {
      return $this->project_model->get_project_detail($company_id, $project_code, TRUE)->row();
   }

   protected function _tampil_subproyek($project_id, $subproject_id=NULL) {
      return $this->project_model->get_subproject($project_id, $subproject_id);
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(Direktur) Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'archived'  => $this->_tampil_arsip(50),
         'page'      => 'arsip_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/arsip/index', $data);
   }

   public function detail($company_id, $project_code) {
      // Get Archived Project
      $project = $this->_detail_proyek($company_id, $project_code);
      $subproject = $this->_tampil_subproyek($project->project_id)->result_array();

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => '(Direktur) Detail Arsip',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'         => 'detail_arsip_proyek'
      ];

      $data['project'] = [
         'project_id'            => $project->project_id,
         'ID_pm'                 => $project->user_id,
         'ID_company'            => $project->company_id,
         'projectID'             => $project->projectID,
         'project_name'          => $project->project_name,
         'project_thumbnail'     => $project->project_thumbnail,
         'project_description'   => $project->project_description,
         'project_start'         => $project->project_start,
         'project_deadline'      => $project->project_deadline,
         'project_status'        => $project->project_status,
         'project_progress'      => $project->project_progress,
         'project_address'       => $project->project_address,
         'project_archive'       => $project->project_archive,
         'user_role'             => $project->user_role,
         'user_fullname'         => $project->user_fullname,
         'user_profile'          => $project->user_profile,
         'comp_name'             => $project->comp_name,
         'subproject'            => $subproject
      ];

      $this->theme->view('templates/main', 'direktur/proyek/arsip/arsip_detail', $data);
   }

   public function detail_proyek_arsip() {
      $project_id = $this->input->post('project_id', TRUE);
      $project_code_ID = $this->input->post('project_code', TRUE);
      $data['docs'] = $this->project_model->get_documentation($project_id, NULL);
      $data['project'] = $this->project_model->detail_archive($project_id, $project_code_ID)->row();
      $this->load->view('direktur/proyek/arsip/info_detail_proyek', $data);
   }

   function arsip_proyek() {
      $message = [];
      $code_id = $this->input->post('project_code', TRUE);
      $this->bm->update($this->tb_project, ['project_archive' => 1], ['project_code_ID' => $code_id]);
      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek telah berhasil diarsipkan.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Proyek gagal disimpan sebagai arsip'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function hapus_arsip() {
      $message = [];
      $project_ID = $this->input->post('project_ID', TRUE);
      $this->bm->update($this->tb_project, [
         'project_archive' => '0', 
         'project_status' => 'pending'
      ], [
         'project_code_ID' => $project_ID
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek telah berhasil dikembalikan ke daftar proyek.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Proses gagal, silahkan coba lagi!'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function tampil_dokumentasi() {
      $post = $this->input->post(NULL, TRUE);
      $data['docs'] = $this->project_model->get_documentation($post['project_id'], $post['subproject_id']);
      $this->load->view('direktur/proyek/arsip/foto_subproyek', $data);
   }

   function info_detail_subproyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['subproject'] = $this->_tampil_subproyek($project_id, $subproject_id)->row();
      $this->load->view('direktur/proyek/arsip/info_detail_subproyek', $data);
   }
}