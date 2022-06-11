<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
	public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Kirim pesan',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'chat_room'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/chat/index', $data);
   }
}