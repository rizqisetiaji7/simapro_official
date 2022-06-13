<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
      $this->load->model('project_model');
   }
}