<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Prioritas extends CI_Controller {
   private $tb_priority = 'tb_priority';
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
   }
   public function tampil_data() {
      $data['priority'] = $this->bm->get($this->tb_priority)->result();
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }
}