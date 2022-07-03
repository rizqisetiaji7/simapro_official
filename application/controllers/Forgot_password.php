<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	private $table = 'tb_users';
   private $token;
   private $token_expiry;

	public function __construct() {
		parent::__construct();
      $this->token = randomID(48);
      $this->token_expiry = now('Asia/Jakarta') + (60*10); // Expired in 10 minutes
	}

	public function index() {
      $this->session->unset_userdata('email_reset');
      is_login();
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Lupa password',
         'desc'      => APP_NAME . ' - ' .'Aplikasi manajemen kontrak PT. Aryabakti Saluyu',
         'page'      => 'lupa_password',
         'footer_copyright'   => '<p class="text-muted text-center mt-4" style="font-size: 14px">&copy; Copyright '.date('Y', now('Asia/Jakarta')).' | Created by '.APP_AUTHOR.'.</p>'
      ];

      $this->theme->view('templates/auth_template', 'forgot_password/index', $data);
   }

   public function send() {
      // Email form validation
      $config = [
         [
            'field'  => 'email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'valid_email'  => 'Format {field} tidak valid.'
            ]
         ]
      ];

      $this->form_validation->set_rules($config);
      // Check if email is not valid
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               'field'           => 'email', 
               'error_message'   => form_error('email', '<span>', '</span>')
            ]
         ];
      } else {
         $email = $this->input->post('email', TRUE);
         $token = $this->token;
         $token_expiry = $this->token_expiry; // Expired in 10 minutes
         $user = $this->bm->get($this->table, '*', ['user_email' => $email])->row();

         // Check if the email is registered or not
         if ($user) {
            $this->bm->update($this->table, [
               'token'        => $token,
               'token_expiry' => $token_expiry
            ], ['user_email' => $email]);

            $dataBody = [
               'email_subject'   => 'Reset Password',
               'email_body'      => '<p>Klik link berikut ini untuk melakukan reset password.</p> <a href="'.site_url('change_password?token='.$token).'">Klik Disini</a>'
            ];

            // Send Link to Email
            $send = $this->mylibs->_sendEmail($email, $user->user_fullname, $token, $dataBody);
            if ($send['status'] == TRUE) {
               $message = [
                  'status'    => 'success',
                  'title'     => 'Email berhasil terkirim',
                  'redirect'  => site_url('login'),
                  'message'   => 'Segera cek inbox/spam untuk melakukan pergantian password. <br/> Link pembaruan hanya berlaku selama 10 menit.'
               ];
            } else {
               $this->bm->update($this->table, ['token' => NULL, 'token_expiry' => NULL], ['user_email' => $email]);
               $message = [
                  'status'       => 'failed',
                  'error_info'   => $send['error_info'],
                  'message'      => 'Pastikan koneksi internet atau akun email anda benar.'
               ];
            }
         } else {
            $message = [
               'status'    => 'error',
               'message'   => 'Oops, email salah! Pastikan email anda sudah terdaftar.'
            ];
         }
      }
   	$this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function change_password() {
      is_login();
      $token = $this->input->get('token', TRUE);

      // Check if token not exists
      if (!$token) {
         $error_message = [
            'error_type'   => 'token',
            'error_icon'   => base_url('assets/img/email-blocker.png'),
            'error_title'  => 'Token tidak tersedia!',
            'error_msg'    => '<p class="text-muted mb-4">Reset password gagal! Silahkan lakukan reset password ulang.</p>
               <a href="'.site_url('forgot_password').'" class="btn btn-dark">Reset ulang</a>'
         ];
         $this->error_display($error_message);
      } else {
         //
         $user = $this->bm->get($this->table, '*', ['token' => $token])->row();
         // Check if user token is exists
         if ($user) {
            $time_now = intval(now('Asia/Jakarta')); // Current Time in timestamp
            $exp_token = intval($user->token_expiry); // Time in 10 minutes later

            // Check token is available or expired
            if ($time_now < $exp_token) {
               $this->session->set_userdata('email_reset', $user->user_email);
               $this->show_change_password_form($user->user_email);  
            } else {
               // Reset token and token expiry to NULL value
               $this->bm->update($this->table, ['token' => NULL, 'token_expiry' => NULL], ['user_email' => $user->user_email]);
               
               // Remove the session and display error
               $this->session->unset_userdata('email_reset');
               $error_message = [
                  'error_type'   => 'token',
                  'error_icon'   => base_url('assets/img/email-blocker.png'),
                  'error_title'  => 'Token Expired!',
                  'error_msg'    => '<p class="text-muted mb-4">Token telah melewati batas waktu! Silahkan lakukan reset password ulang.</p>
                     <a href="'.site_url('forgot_password').'" class="btn btn-dark">Reset ulang</a>'
               ];
               $this->error_display($error_message);
            }
         } else {
            // This is condition if token is not valid
            $this->session->unset_userdata('email_reset');
            $error_message = [
               'error_type'   => 'token',
               'error_icon'   => base_url('assets/img/email-blocker.png'),
               'error_title'  => 'Token tidak valid!',
               'error_msg'    => '<p class="text-muted mb-4">Reset password gagal! Silahkan lakukan reset password ulang.</p>
                  <a href="'.site_url('forgot_password').'" class="btn btn-dark">Reset ulang</a>'
            ];
            $this->error_display($error_message);
         }
      }
   }

   public function show_change_password_form($email = '') {
      is_login();

      // Email is required for validation, if session not exists, this statement will be redirect to login page
      if (!$this->session->userdata('email_reset')) {
         redirect('login');
      } else {
         // Check the parameter. Check if email as parameter is exists
         if ($email != '') {
            $data = [
               'app_name'  => APP_NAME,
               'author'    => APP_AUTHOR,
               'title'     => 'Reset password',
               'desc'      => APP_NAME . ' - ' .'Aplikasi manajemen kontrak PT. Aryabakti Saluyu',
               'page'      => 'lupa_password',
               'footer_copyright'   => '<p class="text-muted text-center mt-4" style="font-size: 14px">&copy; Copyright '.date('Y', now('Asia/Jakarta')).' | Created by '.APP_AUTHOR.'.</p>',
               'key_id'    => base64_encode($email)
            ];
            
            $this->theme->view('templates/auth_template', 'forgot_password/change_password', $data);   
         } else {
            // This condition if email is not exists
            $error_message = [
               'error_type'   => 'email',
               'error_icon'   => base_url('assets/img/email-blocker.png'),
               'error_title'  => 'Oops, terjadi kesalahan!',
               'error_msg'    => '<p class="text-muted mb-4">Reset password gagal! Silahkan lakukan reset password ulang.</p>
                  <a href="'.site_url('forgot_password').'" class="btn btn-dark">Coba lagi</a>'
            ];
            $this->error_display($error_message);
         }
      }      
   }

   public function reset_process() {
      $post = $this->input->post(NULL, TRUE);
      $config = [
         [
            'field'  => 'new_password',
            'label'  => 'Password',
            'rules'  => 'trim|required|min_length[8]',
            'errors' => [
               'required'     => '{field} baru wajib diisi.',
               'min_length'   => '{field} minimal terdiri dari 8 karakter.'
            ]
         ],
         [
            'field'  => 'confirm_password',
            'label'  => 'Konfirmasi password',
            'rules'  => 'trim|required|min_length[8]|matches[new_password]',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'min_length'   => '{field} minimal terdiri dari 8 karakter.',
               'matches'      => '{field} tidak sesuai.'
            ]
         ]
      ];

      $this->form_validation->set_rules($config);
      if (!$this->form_validation->run()) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'new_password', 'error_message' => form_error('new_password', '<span>', '</span>')],
               ['field' => 'confirm_password', 'error_message' => form_error('confirm_password', '<span>', '</span>')]
            ]
         ];
      } else {
         $email = base64_decode($post['key_ID']);
         $password = password_hash($post['new_password'], PASSWORD_DEFAULT);
         $query = $this->bm->update($this->table, ['user_password' => $password, 'token' => NULL, 'token_expiry' => NULL], ['user_email' => $email]);

         $this->session->unset_userdata('email_reset');

         if ($query) {
            $message = [
               'status'    => 'success',
               'title'     => 'Password berhasil di ganti',
               'redirect'  => site_url('login'),
               'message'   => 'Silahkan login untuk masuk ke halaman dashboard.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'title'     => 'Password gagal di ganti',
               'redirect'  => site_url('forgot_password'),
               'message'   => 'Silahkan ulangi untuk melakukan reset password baru.'
            ];
         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function error_display($error_message = []) {
      is_login();
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Oops! Terjadi kesalahan',
         'desc'      => APP_NAME . ' - ' .'Aplikasi manajemen kontrak PT. Aryabakti Saluyu',
         'page'      => 'error_display',
         'message'   => $error_message
      ];

      $this->theme->view('templates/auth_template', 'forgot_password/error_display', $data);
   }
}