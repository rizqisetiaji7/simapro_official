<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Daftar Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'daftar_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/daftar_proyek/index', $data);
   }

   public function detail_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Detail Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'detail_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/detail_proyek/index', $data);
   }

   public function riwayat_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'riwayat_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/riwayat', $data);
   }

   public function arsip_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'arsip_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/arsip', $data);
   }
}