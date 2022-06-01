<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_subdirektur();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Dashboard Direktur',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'sub_direktur'
      ];
      $this->theme->view('templates/main', 'sub_direktur/dashboard', $data);
   }
}