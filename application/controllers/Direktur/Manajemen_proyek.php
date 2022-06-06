<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }

   function form_tambah_subproyek() {
      $this->load->view('direktur/proyek/detail_proyek/subproyek/modal_add_form');
   }

   function form_edit_subproyek() {
      $this->load->view('direktur/proyek/detail_proyek/subproyek/modal_edit_form');
   }

   function form_tambah_subelemen_proyek() {
      $this->load->view('direktur/proyek/detail_proyek/subelemen_proyek/modalsubelemen_add_form');
   }

   function form_edit_subelemen_proyek() {
      $this->load->view('direktur/proyek/detail_proyek/subelemen_proyek/modalsubelemen_edit_form');
   }

   // function hapus() {
   //    echo 'Hapus';
   // }
}