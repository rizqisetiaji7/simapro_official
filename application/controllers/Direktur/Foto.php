<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }

   function tampil_foto() {

   }
}