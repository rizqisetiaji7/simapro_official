<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {
   private $tb_project = 'tb_project';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      unset_chat_session();
      $this->load->model('project_model');
   }

   public function _detail_proyek($company_id, $project_code) {
      return $this->project_model->get_project_detail($company_id, $project_code)->row();
   }

   public function _tampil_subproyek($project_id, $subproject_id=NULL) {
      return $this->project_model->get_subproject($project_id, $subproject_id);
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
      $this->load->view('direktur/proyek/riwayat/foto_desain_proyek', $data);
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(Direktur) Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'riwayat_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/riwayat/index', $data);
   }

   public function tampil_riwayat_proyek() {
      $data['projects'] = $this->project_model->get_finished_project(user_company()->company_id, 15);
      $this->load->view('direktur/proyek/riwayat/list_proyek', $data);
   }

   public function filter_data() {
      $post = $this->input->post(NULL, TRUE);
      $query = '';
      if ($post['bulan_awal'] == '' && $post['bulan_akhir'] == '') {
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] == '' && $post['bulan_akhir'] != '') {
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] == '') {
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] != ''){
         $ym_awal = $post['tahun'].'-'.$post['bulan_awal'];
         $ym_akhir = $post['tahun'].'-'.$post['bulan_akhir'];
         $query = $this->project_model->get_riwayat_filter($ym_awal, $ym_akhir, user_company()->company_id);
      }
      $data['filtered'] = $query;
      $this->load->view('direktur/proyek/riwayat/filtered_data', $data);
   }

   public function detail($company_id, $project_code) {
      // Get Archived Project
      $project = $this->_detail_proyek($company_id, $project_code);
      $subproject = $this->_tampil_subproyek($project->project_id)->result_array();

      /**
       * ==================================
       * SHOW PREVIEW PROJECT DESIGN PHOTOS
       * ==================================
       */
      $project_design = $this->project_model->get_documentation($project->project_id, NULL, 'design', 1);

      $data = [
         'app_name'        => APP_NAME,
         'author'          => APP_AUTHOR,
         'title'           => '(Direktur) Proyek Detail',
         'desc'            => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'            => 'riwayat_detail',
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

      $this->theme->view('templates/main', 'direktur/proyek/riwayat/detail', $data);
   }

   public function info_detail_proyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $project_code_ID = $this->input->post('project_code', TRUE);
      $data['project'] = $this->project_model->get_project_detail(user_company()->company_id, $project_code_ID)->row();
      $this->load->view('direktur/proyek/riwayat/info_detail_proyek', $data);
   }

   public function info_detail_subproyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['subproject'] = $this->_tampil_subproyek($project_id, $subproject_id)->row();
      $this->load->view('direktur/proyek/riwayat/info_detail_subproyek', $data);
   }

   public function tampil_foto() {
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['subproject_id'] == '' ? NULL : $post['subproject_id'];
      $data['docs'] = $this->project_model->get_documentation($project_id, $subproject_id);
      $this->load->view('direktur/proyek/riwayat/foto_dokumentasi', $data);
   }
}