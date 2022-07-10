<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelola_pm extends CI_Controller {
   private $table_users = 'tb_users';
   private $default_avatar = 'default-avatar.jpg';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      unset_chat_session();
   }

   private function _file_upload_config($filePath = './assets/img') {
      $config = [
         'upload_path'   => $filePath,
         'allowed_types' => 'jpg|jpeg|png',
         'encrypt_name'  => TRUE,
         'remove_spaces' => TRUE
      ];
      return $config;
   }

   private function _set_user_rules() {
      $config = [
         [
            'field'  => 'user_fullname',
            'label'  => 'Nama lengkap',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} tidak boleh kosong.'
            ]
         ],
         [
            'field'  => 'user_email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} tidak boleh kosong.',
               'valid_email'  => '{field} tidak valid, silahkan isi format email dengan benar.'
            ]
         ],
         [
            'field'  => 'user_password',
            'label'  => 'Password',
            'rules'  => 'trim|required|min_length[5]',
            'errors' => [
               'required'     => '{field} tidak boleh kosong.',
               'min_length'   => '{field} minimal terdiri dari 5 digit karakter.'
            ]
         ],
         [
            'field'  => 'password_confirm',
            'label'  => 'Konfirmasi Password',
            'rules'  => 'trim|required|matches[user_password]',
            'errors' => [
               'required'  => '{field} tidak boleh kosong.',
               'matches'   => '{field} tidak valid, silahkan isi dengan benar.'
            ]
         ],
         [
            'field'  => 'user_phone',
            'label'  => 'Nomor Telepon',
            'rules'  => 'trim|numeric|min_length[10]|max_length[15]',
            'errors' => [
               'numeric'      => '{field} wajib berisi angka.',
               'min_length'   => '{field} minimal terdiri dari 10 digit angka.',
               'max_length'   => '{field} maksimal terdiri dari 15 digit angka.'
            ]
         ]
      ];
      return $config;
   }

   private function _set_edit_rules() {
      $config = [
         [
            'field'  => 'user_fullname',
            'label'  => 'Nama lengkap',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} tidak boleh kosong.'
            ]
         ],
         [
            'field'  => 'user_email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} tidak boleh kosong.',
               'valid_email'  => '{field} tidak valid, silahkan isi format email dengan benar.'
            ]
         ],
         [
            'field'  => 'user_phone',
            'label'  => 'Nomor Telepon',
            'rules'  => 'trim|numeric|min_length[10]|max_length[15]',
            'errors' => [
               'numeric'      => '{field} hanya boleh berisi angka.',
               'min_length'   => '{field} minimal terdiri dari 10 digit angka.',
               'max_length'   => '{field} maksimal terdiri dari 15 digit angka.'
            ]
         ]
      ];
      return $config;
   }

   private function _set_password_rules() {
      $config = [
         [
            'field'  => 'user_password',
            'label'  => 'Password',
            'rules'  => 'trim|required|min_length[5]',
            'errors' => [
               'required'     => '{field} tidak boleh kosong.',
               'min_length'   => '{field} minimal terdiri dari 5 digit karakter.'
            ]
         ],
         [
            'field'  => 'password_confirm',
            'label'  => 'Konfirmasi Password',
            'rules'  => 'trim|required|matches[user_password]',
            'errors' => [
               'required'  => '{field} tidak boleh kosong.',
               'matches'   => '{field} tidak valid, silahkan isi dengan benar.'
            ]
         ]
      ];
      return $config;
   }

   public function tampil_pm() {
      $pm = $this->bm->get($this->table_users, '*', ['ID_company' => user_company()->company_id, 'user_role' => 'pm'])->result();
      $data['projek_manajer'] = $pm;
      $this->load->view('direktur/perusahaan/data_proyek_manajer', $data);
   }

   public function form_tambah() {
      $this->load->view('direktur/perusahaan/form_add_pm');
   }

   public function form_edit() {
      $user_unique_id = $this->input->post('user_unique_id', TRUE);
      $user_role = $this->input->post('user_role', TRUE);
      $data['user'] = $this->bm->get($this->table_users, '*', [
         'user_unique_id' => $user_unique_id, 
         'user_role' => $user_role
      ])->row();
      $this->load->view('direktur/perusahaan/form_edit_pm', $data);
   }

   public function form_password() {
      $data['unique_id'] = $this->input->post('unique_id', TRUE);
      $data['user_role'] = $this->input->post('user_role', TRUE);
      $this->load->view('direktur/perusahaan/form_password_pm', $data);
   }

   public function tambah() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->form_validation->set_rules($this->_set_user_rules());

      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status' => 'validation_error',
            'message' => [
               ['field' => 'user_fullname', 'err_message' => form_error('user_fullname', '<span>','</span>')],
               ['field' => 'user_email', 'err_message' => form_error('user_email', '<span>','</span>')],
               ['field' => 'user_password', 'err_message' => form_error('user_password', '<span>','</span>')],
               ['field' => 'password_confirm', 'err_message' => form_error('password_confirm', '<span>','</span>')],
               ['field' => 'user_phone', 'err_message' => form_error('user_phone', '<span>','</span>')]
            ]
         ];
      } else {
         $data = [
            'ID_company'      => user_company()->company_id,
            'user_unique_id'  => getIDCode('PM', user_company()->comp_prefix),
            'user_role'       => 'pm',
            'user_fullname'   => $post['user_fullname'],
            'user_email'      => $post['user_email'],
            'user_password'   => password_hash($post['user_password'], PASSWORD_DEFAULT),
            'user_phone'      => $post['user_phone'],
            'user_address'    => $post['user_address'],
            'theme_mode'      => '0',
            'created'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         // Initialize Config upload
         $this->upload->initialize($this->_file_upload_config('./uploads/profile'));
         if (@$_FILES['profile_image']['name'] != NULL) {
            if ($this->upload->do_upload('profile_image')) {
               $photo = $this->upload->data();
               resize_image('./uploads/profile/'.$photo['file_name']);
               $data['user_profile'] = $photo['file_name'];
               $this->bm->save($this->table_users, $data);
               if ($this->db->affected_rows() > 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data Proyek Manajer telah berhasil disimpan.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data Proyek Manajer gagal disimpan.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data Proyek Manajer gagal disimpan.'
               ];
            }
         } else {
            $data['user_profile'] = $this->default_avatar;
            $this->bm->save($this->table_users, $data);
            if ($this->db->affected_rows() > 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data Proyek Manajer telah berhasil disimpan.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data Proyek Manajer gagal disimpan.'
               ];
            }
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function edit() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_set_edit_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status' => 'validation_error',
            'message' => [
               ['field' => 'user_fullname', 'err_message' => form_error('user_fullname', '<span>','</span>')],
               ['field' => 'user_email', 'err_message' => form_error('user_email', '<span>','</span>')],
               ['field' => 'user_phone', 'err_message' => form_error('user_phone', '<span>','</span>')]
            ]
         ];
      } else {
         $data = [
            'user_fullname'   => $post['user_fullname'],
            'user_email'      => $post['user_email'],
            'user_phone'      => $post['user_phone'],
            'user_address'    => $post['user_address'],
            'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         // Initialize Config upload
         $this->upload->initialize($this->_file_upload_config('./uploads/profile'));
         if (@$_FILES['profile_image']['name'] != NULL) {
            if ($this->upload->do_upload('profile_image')) {
               if ($post['old_profile'] != $this->default_avatar) {
                  unlink('./uploads/profile/'.$post['old_profile']);
               }
               $photo = $this->upload->data();
               resize_image('./uploads/profile/'.$photo['file_name']);
               $data['user_profile'] = $photo['file_name'];
               $this->bm->update($this->table_users, $data, [
                  'user_unique_id'  => $post['user_unique_id'],
                  'user_role'       => $post['user_role']
               ]);

               if ($this->db->affected_rows() >= 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data Proyek Manajer telah berhasil diperbarui.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data Proyek Manajer gagal diperbarui.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data Proyek Manajer gagal diperbarui.'
               ];
            }
         } else {
            $data['user_profile'] = $post['old_profile'];
            $this->bm->update($this->table_users, $data, [
               'user_unique_id'  => $post['user_unique_id'],
               'user_role'       => $post['user_role']
            ]);

            if ($this->db->affected_rows() >= 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data Proyek Manajer telah berhasil diperbarui.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data Proyek Manajer gagal diperbarui.'
               ];
            }
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
   
   public function disable_akun() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->bm->update($this->table_users, [
         'account_status'  => 'disable',
         'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ], [
         'user_id' => $post['user_id'], 
         'user_unique_id' => $post['unique_id']
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Akun proyek manajer berhasil di Non-Aktifkan!.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf akun proyek manajer gagal di Non-Aktifkan!.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function enable_akun() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->bm->update($this->table_users, [
         'account_status'  => 'enable',
         'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ], [
         'user_id' => $post['user_id'], 
         'user_unique_id' => $post['unique_id']
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Akun proyek manajer berhasil di Aktifkan!.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf akun proyek manajer gagal di Aktifkan!.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
   

   public function ubah_password() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_set_password_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status' => 'validation_error',
            'message' => [
               ['field' => 'user_password', 'err_message' => form_error('user_password', '<span>','</span>')],
               ['field' => 'password_confirm', 'err_message' => form_error('password_confirm', '<span>','</span>')]
            ]
         ];
      } else {
         $this->bm->update($this->table_users, [
            'user_password'   => password_hash($post['user_password'], PASSWORD_DEFAULT),
            'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ], [
            'user_unique_id'  => $post['user_unique_id'],
            'user_role'       => $post['user_role']
         ]);

         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Password Proyek Manajer telah berhasil diperbarui.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Maaf Password Proyek Manajer gagal diperbarui.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}