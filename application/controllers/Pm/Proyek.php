<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
   }

   function tampil_form_edit_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/form_edit_proyek');
   }

   function tampil_form_edit_status_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/form_edit_status_proyek');
   }

   function tampil_foto_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/foto_dokumentasi_proyek');
   }

   function tampil_foto_subproyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/foto_dokumentasi_subproyek');
   }

   function tampil_form_tambah_subproyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subproyek/modal_add_form');
   }

   function tampil_form_edit_subproyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subproyek/modal_edit_form');
   }

   function form_tambah_subelemen_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subelemen/modalsubelemen_add_form');
   }

   function form_edit_subelemen_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subelemen/modalsubelemen_edit_form');
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Proyek Manajer',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek'
      ];
      $this->theme->view('templates/main', 'pm/proyek/daftar/index', $data);
   }

   public function detail() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Proyek Detail',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_detail'
      ];
      $this->theme->view('templates/main', 'pm/proyek/detail/index', $data);
   }

   public function arsip() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_arsip'
      ];
      $this->theme->view('templates/main', 'pm/proyek/arsip/index', $data);
   }

   public function riwayat() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_riwayat'
      ];
      $this->theme->view('templates/main', 'pm/proyek/riwayat/index', $data);
   }
}