<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }

   public function index() {
      $projects = $this->project_model->get_all_user_project(user_login()->ID_company)->result();
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Daftar Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $projects,
         'page'      => 'daftar_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/daftar_proyek/index', $data);
   }

   function form_tambah() {
      $data['project_code_ID'] = urlencode(base64_encode(getIDCode('PROY', user_company()->comp_prefix)));
      $data['project_man'] = $this->bm->get('tb_users', 'user_id, user_fullname', ['ID_company' => user_company()->company_id, 'user_role' => 'pm'])->result();
      $this->load->view('direktur/proyek/daftar_proyek/form_tambah_proyek', $data);
   }

   public function detail_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Detail Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'detail_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/detail_proyek/index', $data);
   }

   public function riwayat_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'riwayat_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/riwayat', $data);
   }

   public function arsip_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'arsip_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/arsip', $data);
   }
}