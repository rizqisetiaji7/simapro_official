<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
      unset_chat_session();
      $this->load->model('project_model');
   }

   public function tampil_arsip($limit) {
      $comp_id = user_company()->company_id;
      $pm_id = user_company()->user_id;
      return $this->ppm->get_pm_project_archive($comp_id, $pm_id, $limit)->result();
   }

   public function tampil_subproyek($project_id, $subproject_id = NULL) {
      return $this->ppm->get_subprojectpm($project_id, $subproject_id);
   }

   public function detail_proyek($comp_id, $project_code, $pm_id) {
      return $this->ppm->get_projectpm_detail($comp_id, $project_code, $pm_id)->row();
   }

   /**
    * =======================================
    * SHOW DATA LIST OF PROJECT DESIGN PHOTOS
    * =======================================
    */
   function tampil_foto_desain() {
      $post = $this->input->post(NULL, TRUE);
      $data['project_name'] = $post['project_name'];
      $data['project_id'] = $post['project_id'];
      $data['docs'] = $this->project_model->get_documentation($post['project_id'], NULL, $post['photo_category']);
      $this->load->view('pm/proyek/arsip/foto_desain_proyek', $data);
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(PM) Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'archived'  => $this->tampil_arsip(50),
         'page'      => 'proyek_arsip'
      ];
      $this->theme->view('templates/main', 'pm/proyek/arsip/index', $data);
   }

   public function detail($company_id, $project_code_ID) {
      $project = $this->detail_proyek($company_id, $project_code_ID, user_login()->user_id);
      $subproject = $this->tampil_subproyek($project->project_id)->result_array();

      /**
       * ==================================
       * SHOW PREVIEW PROJECT DESIGN PHOTOS
       * ==================================
       */
      $project_design = $this->project_model->get_documentation($project->project_id, NULL, 'design', 1);

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => '(PM) Detail Arsip',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'         => 'detail_arsip_proyek',
         'project_design'  => $project_design
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
         'user_id'               => $project->user_id,
         'user_role'             => $project->user_role,
         'user_fullname'         => $project->user_fullname,
         'user_profile'          => $project->user_profile,
         'account_status'        => $project->account_status,
         'comp_name'             => $project->comp_name,
         'subproject'            => $subproject
      ];
      $this->theme->view('templates/main', 'pm/proyek/arsip/arsip_detail', $data);
   }

   function arsip_proyek() {
      $message = [];
      $code_id = $this->input->post('project_code', TRUE);
      $this->bm->update('tb_project', ['project_archive' => 1], [
         'project_code_ID' => $code_id
      ]);

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
      $this->bm->update('tb_project', [
         'project_archive' => '0', 
         'project_status' => 'pending'
      ], [
         'ID_pm'           => user_login()->user_id,
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

   function detail_proyek_arsip() {
      $project_id = $this->input->post('project_id', TRUE);
      $project_code_ID = $this->input->post('project_code', TRUE);
      $data['docs'] = $this->ppm->get_documentation($project_id, NULL);
      $data['project'] = $this->ppm->detail_pm_project($project_id, $project_code_ID, user_login()->user_id)->row();
      $this->load->view('pm/proyek/arsip/info_detail_proyek', $data);
   }

   function tampil_dokumentasi() {
      $post = $this->input->post(NULL, TRUE);
      $data['docs'] = $this->ppm->get_documentation($post['project_id'], $post['subproject_id']);
      $this->load->view('pm/proyek/arsip/foto_subproyek', $data);
   }

   function info_detail_subproyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['subproject'] = $this->tampil_subproyek($project_id, $subproject_id)->row();
      $this->load->view('pm/proyek/arsip/info_detail_subproyek', $data);
   }
}