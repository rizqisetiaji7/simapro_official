<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $table = 'tb_users';
   // private $col_select = 'user_id, tb_user_role.role_id, role_code, password';

	public function __construct() {
      parent::__construct();
   }

   private function _set_response($status = '', $field = [], $data = [], $message = '') {
      $message = [
         'status'  => $status,
         'field'   => $field,
         'data'    => $data,
         'message' => $message
      ];
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   private function _login_rules() {
      $config = [
         [
            'field'  => 'email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'valid_email'  => '{field} tidak valid. Silahkan isi email dengan benar.'
            ],
         ],
         [
            'field'  => 'password',
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
               'required'     => '{field} wajib diisi.'
            ],
         ]
      ];

      return $config;
   }


   public function index() {
      is_login();
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Login',
         'desc'      => APP_NAME . ' - ' .'Aplikasi manajemen kontrak PT. Aryabakti Saluyu',
         'page'      => 'login',
         'footer_copyright'   => '<p class="text-muted text-center mt-4" style="font-size: 14px">&copy; Copyright '.date('Y', now('Asia/Jakarta')).' | Created by '.APP_AUTHOR.'.</p>'
      ];
      $this->theme->view('templates/auth_template', 'login', $data);
   }

   function login_process() {
      is_login();

      $post = $this->input->post(NULL, TRUE);
      // Set Rules
      $this->form_validation->set_rules($this->_login_rules());
      
      if ($this->form_validation->run() == false) {
         $validation_message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field'  => 'email', 'error_message' => form_error('email', '<span>', '</span>')],
               ['field'  => 'password', 'error_message' => form_error('password', '<span>', '</span>')],
            ]
         ];
         $this->output->set_content_type('application/json')->set_output(json_encode($validation_message));
      } else {
         $where['user_email'] = $post['email'];
         $query = $this->bm->get($this->table, '*', $where);

         if ($query->num_rows() > 0) {
            $user = $query->row();
            if (password_verify($post['password'], $user->user_password)) {
               $redirect_url = '';

               if ($user->user_role == 'super_admin') {
                  $redirect_url = site_url('direktur');
               } else if ($user->user_role == 'admin') {
                  $redirect_url = site_url('sub_direktur');
               } else {
                  $redirect_url = site_url('mandor');
               }

               $this->session->set_userdata(['user_id' => $user->user_id]);
               $this->_set_response('success', ['email','password'], ['redirect' => $redirect_url], 'Selamat Anda telah berhasil login.');
            } else {
               $this->_set_response('failed', 'password', ['form' => 'Password'], 'Silahkan isi password dengan benar.');
            }
         } else {
            $this->_set_response('failed', 'email', ['form' => 'Email'], 'Silahkan isi email dengan benar.');
         }
      }
   }

   function logout() {
      $this->session->unset_userdata(['user_id']);
      redirect('login');
   }
}