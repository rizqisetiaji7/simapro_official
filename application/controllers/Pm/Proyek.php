<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Proyek Manajer',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek'
      ];
      $this->theme->view('templates/main', 'pm/proyek/index', $data);
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
      $this->theme->view('templates/main', 'pm/proyek/arsip', $data);
   }

   public function riwayat() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_riwayat'
      ];
      $this->theme->view('templates/main', 'pm/proyek/riwayat', $data);
   }
}