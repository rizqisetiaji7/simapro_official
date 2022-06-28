<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
	public function __construct() {
      parent::__construct();
      is_not_login();
   }

   function set_chat_data() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      if ($post['to_user'] == 0) {
         $message = [
            'status'    => 'failed',
            'message'   => 'Tidak ada user yang dituju!'
         ];
      } else {
         $this->session->set_userdata([
            'from_user'    => $post['from_user'],
            'to_user'      => $post['to_user'],
            'project_id'   => $post['project_id']
         ]);

         $message = [
            'status'    => 'success',
            'redirect'  => site_url('chatbox')
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   private function _get_message($data) {
      return $this->chat->get_message($data)->result_array();
   }

   private function _get_user($data) {
      return $this->chat->get_user($data)->row_array();
   }

   private function _get_project($data) {
      return $this->chat->get_project($data)->row_array();
   }

   public function index() {
      $from_user = $this->session->userdata('from_user');
      $to_user = $this->session->userdata('to_user');
      $project_id = $this->session->userdata('project_id');

      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Kirim pesan',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'sender'    => $this->_get_user(['user_id' => $from_user]),
         'receiver'  => $this->_get_user(['user_id' => $to_user]),
         'project'   => $this->_get_project($project_id),
         'messages'  => $this->_get_message([
            'from_user'    => $from_user,
            'to_user'      => $to_user,
            'project_id'   => $project_id
         ]),
         'data_usr'  => [
            'from_user'    => $from_user,
            'to_user'      => $to_user,
            'project_id'   => $project_id
         ],
         'page'      => 'chat_room'
      ];
      $this->theme->view('templates/main', 'chat/index', $data);
   }
}