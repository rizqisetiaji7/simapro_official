<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subelemen extends CI_Controller {
   private $tb_subelemen = 'tb_project_task';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }

   function form_tambah_subelemen() {

   }

   function form_edit_subelemen() {

   }

   function tambah() {

   }

   function edit() {
      
   }

   function hapus() {
      
   }
}