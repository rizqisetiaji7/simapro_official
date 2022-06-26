<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subproyek extends CI_Controller {
   private $tb_subproject = 'tb_subproject';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }
}