<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
   private $tb_chat = 'tb_livechat';
   private $app_id;
   private $key;
   private $secret;
   private $cluster;

	public function __construct() {
      parent::__construct();
      is_not_login();
      $this->app_id  = '1431182';
      $this->key     = '051a295c0e08e48dd009';
      $this->secret  = '25bc07e769d52ee898bd';
      $this->cluster = 'ap1';
   }

   protected function _get_pusher($message) {
      $pusher = new Pusher\Pusher($this->key, $this->secret, $this->app_id, [
         'cluster' => $this->cluster,
         'useTLS' => true
      ]);
      return $pusher->trigger('simapro-chat','listen',$message);
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

   public function tampil_pesan() {
      $from_user = $this->session->userdata('from_user');
      $to_user = $this->session->userdata('to_user');
      $project_id = $this->session->userdata('project_id');
      $data = [
         'sender'    => $this->_get_user(['user_id' => $from_user]),
         'receiver'  => $this->_get_user(['user_id' => $to_user]),
         'project'   => $this->_get_project($project_id),
         'messages'  => $this->_get_message([
            'from_user'    => $from_user,
            'to_user'      => $to_user,
            'project_id'   => $project_id
         ]),
         'data_msg'  => [
            'from_user'    => $from_user,
            'to_user'      => $to_user,
            'project_id'   => $project_id
         ]
      ];
      $this->load->view('chat/daftar_pesan', $data);
   }

   public function index() {
      is_not_chat();
      $from_user = $this->session->userdata('from_user');
      $to_user = $this->session->userdata('to_user');
      $project_id = $this->session->userdata('project_id');

      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => user_login()->user_role == 'direktur' ? '(Direktur) Kirim pesan' : '(PM) Kirim pesan',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'sender'    => $this->_get_user(['user_id' => $from_user]),
         'receiver'  => $this->_get_user(['user_id' => $to_user]),
         'project'   => $this->_get_project($project_id),
         'data_msg'  => [
            'from_user'    => $from_user,
            'to_user'      => $to_user,
            'project_id'   => $project_id
         ],
         'page'      => 'chat_room'
      ];
      $this->theme->view('templates/main', 'chat/index', $data);
   }

   function kirim_pesan() {
      $message = [];
      $this->form_validation->set_rules('chat_message', 'Pesan', 'required', [
         'required'  => 'Oops! Pesan kosong.'
      ]);
      if (!$this->form_validation->run()) {
         $message = [
            'status'    => 'failed',
            'header'    => form_error('chat_message', '<h3 class="mb-2">','</h3>'),
            'message'   => 'Anda tidak diperkenankan mengirim pesan kosong.',
            'icon'      => base_url('assets/img/no-message.png')
         ];
      } else {
         $data = [
            'ID_project'   => $this->input->post('ID_project', TRUE),
            'ID_sender'    => $this->input->post('ID_sender', TRUE),
            'ID_receiver'  => $this->input->post('ID_receiver', TRUE),
            'chat_message' => $this->input->post('chat_message', TRUE),
            'chat_type'    => 'text',
            'chat_status'  => NULL,
            'chat_created' => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];
         $this->bm->save($this->tb_chat, $data);

         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'   => 'success',
               'message'  => 'Pesan Terkirim'
            ];  
         } else {
            $message = [
               'status'   => 'error_message',
               'header'   => '<h3 class="mb-2">Oops! Terjadi Masalah!</h3>',
               'message'  => 'Pesan tidak terkirim, silahkan periksa koneksi internet anda, lalu coba lagi.',
               'icon'     => base_url('assets/img/chat-warning.png')
            ];
         }
      }
      $this->_get_pusher($message);
   }
}