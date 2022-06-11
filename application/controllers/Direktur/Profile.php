<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
   private $tb_users = 'tb_users';
   private $default_avatar = 'default-avatar.jpg';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('company_model');
   }

   private function _file_upload_config($filePath = './assets/img') {
      $config = [
         'upload_path'   => $filePath,
         'allowed_types' => 'jpg|jpeg|png|svg',
         'max_size'      => 4096, // 4MB
         'encrypt_name'  => TRUE,
         'remove_spaces' => TRUE
      ];
      return $config;
   }

   private function _rules_password() {
      $config = [
         [
            'field'  => 'new_password',
            'label'  => 'Password baru',
            'rules'  => 'trim|required|min_length[6]',
            'errors' => [
               'required'    => '{field} tidak boleh kosong.',
               'min_length'  => '{field} minimal terdiri dari 6 karakter.'
            ]
         ],
         [
            'field'  => 'confirm_password',
            'label'  => 'Konfirmasi Password',
            'rules'  => 'trim|required|matches[new_password]',
            'errors' => [
               'required' => '{field} tidak boleh kosong.',
               'matches'  => '{field} tidak valid, silahkan isi dengan benar.'
            ]
         ]
      ];
      return $config;
   }

   private function _rules() {
      $config = [
         [
            'field'  => 'user_email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'valid_email'  => 'Format {field} tidak valid. Silahkan isi email dengan benar.'
            ]
         ],
         [
            'field'  => 'user_fullname',
            'label'  => 'Nama lengkap',
            'rules'  => 'trim|required',
            'errors' => [
               'required'     => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'user_phone',
            'label'  => 'Nomor telepon',
            'rules'  => 'trim|numeric|min_length[10]|max_length[15]',
            'errors' => [
               'numeric'      => '{field} wajib karakter angka.',
               'min_length'   => '{field} minimal 10 digit angka.',
               'max_length'   => '{field} maksimal 15 digit angka.'
            ]
         ]
      ];

      return $config;
   }

   function tampil_profile($tb, $field, $data) {
      return $this->bm->get($tb, $field, $data)->row();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Profile Direktur',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'company'   => $this->company_model->get_company(user_login()->user_id)->row(),
         'page'      => 'profile_direktur'
      ];
      $this->theme->view('templates/main', 'direktur/profile/index', $data);
   }

   function show_upload_profile_form() { 
      $unique_id = base64_decode(urldecode($this->input->post('unique_id', TRUE)));
      $user_role = base64_decode(urldecode($this->input->post('user_role', TRUE)));     

      $data['user'] = $this->tampil_profile($this->tb_users, 'user_profile, user_unique_id, user_role', [
         'user_unique_id' => $unique_id,
         'user_role'      => $user_role
      ]);

      $this->load->view('direktur/profile/upload_profile_form', $data);
   }

   function upload_foto_profile() {
      $message = [];
      $unique_id = urldecode(base64_decode($this->input->post('unique_id', TRUE)));
      $user_role = urldecode(base64_decode($this->input->post('user_role', TRUE)));
      $old_profile = $this->input->post('old_profile', TRUE);

      $message = [
         'unique_id'    => $unique_id,
         'user_role'    => $user_role,
         'old_profile'  => $old_profile
      ];
      
      $this->upload->initialize($this->_file_upload_config('./uploads/profile'));

      // Update profile picture
      if (@$_FILES['profile_image']['name'] != NULL) {
         if ($this->upload->do_upload('profile_image')) {
            if ($old_profile != $this->default_avatar) {
               unlink('./uploads/profile/'.$old_profile);
            }

            $data = [
               'user_profile' => $this->upload->data('file_name'),
               'updated'      => date('Y-m-d H:i:s', now('Asia/Jakarta'))
            ];

            $this->bm->update($this->tb_users, $data, [
               'user_unique_id'  => $unique_id,
               'user_role'       => $user_role
            ]);

            if ($this->db->affected_rows() >= 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Foto profile telah berhasil dipebarui.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Foto profile gagal dipebarui.'
               ];
            }
         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function hapus_foto_profile() {
      $message = [];
      $unique_id = urldecode(base64_decode($this->input->post('unique_id', TRUE)));
      $user_profile = urldecode(base64_decode($this->input->post('user_profile', TRUE)));

      unlink('./uploads/profile/'.$user_profile);

      $this->bm->update($this->tb_users, [
         'user_profile' => $this->default_avatar,
         'updated'      => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ], [
         'user_unique_id' => $unique_id
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Foto profile telah berhasil dihapus.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Foto profile gagal dihapus.'
         ];
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function edit_direktur() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->form_validation->set_rules($this->_rules());

      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'user_email', 'err_message' => form_error('user_email', '<span>','</span>')],
               ['field' => 'user_fullname', 'err_message' => form_error('user_fullname', '<span>','</span>')],
               ['field' => 'user_phone', 'err_message' => form_error('user_phone', '<span>','</span>')]
            ]
         ];
      } else {

         $unique_id = urldecode(base64_decode($post['user_unique_id']));
         $user_role = urldecode(base64_decode($post['user_role']));

         $data = [
            'user_fullname'   => $post['user_fullname'],
            'user_email'      => $post['user_email'],
            'user_phone'      => $post['user_phone'],
            'user_address'    => $post['user_address'],
            'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         $this->bm->update($this->tb_users, $data, [
            'user_unique_id'  => $unique_id,
            'user_role'       => $user_role
         ]);

         if ($this->db->affected_rows() >= 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Data profile telah berhasil diperbarui.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Data profile gagal diperbarui.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function ganti_password() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rules_password());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'new_password', 'err_message' => form_error('new_password', '<span>','</span>')],
               ['field' => 'confirm_password', 'err_message' => form_error('confirm_password', '<span>','</span>')]
            ]
         ];
      } else {
         $this->bm->update($this->tb_users, [
            'user_password'   => password_hash($post['new_password'], PASSWORD_DEFAULT),
            'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ], [
            'user_unique_id'  => urldecode(base64_decode($post['user_unique_id'])),
            'user_role'       => urldecode(base64_decode($post['user_role']))
         ]);

         if ($this->db->affected_rows() >= 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Password telah berhasil diperbarui.',
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Password gagal diperbarui.',
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}