<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Daftar pengguna',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'pengguna'
      ];
      $this->theme->view('templates/main', 'direktur/pengguna/index', $data);
   }
}