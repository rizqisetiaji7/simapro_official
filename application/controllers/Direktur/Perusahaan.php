<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller {
   private $table = 'tb_company';
   private $table_users = 'tb_users';
   private $placeholder = 'default-placeholder320x320.png';
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

   private function _rules() {
      $config = [
         [
            'field'  => 'comp_name',
            'label'  => 'Nama anak perusahaan',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'comp_email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'valid_email'  => 'Format {field} tidak valid. Silahkan isi email dengan benar.',
            ]
         ],
         [
            'field'  => 'comp_phone',
            'label'  => 'Nomor telepon',
            'rules'  => 'trim|required|numeric|min_length[10]|max_length[15]',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'numeric'      => '{field} wajib angka.',
               'min_length'   => '{field} minimal 10 digit angka.',
               'max_length'   => '{field} maksimal 15 digit angka.'
            ]
         ],
         [
            'field'  => 'comp_type',
            'label'  => 'Tipe perusahaan',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'comp_since',
            'label'  => 'Tanggal',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ]
      ];

      return $config;
   }

   private function _user_rules() {
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

   private function _edit_rules() {
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

   private function _password_rules() {
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

   public function index() {
      $getMainComp = $this->company_model->get_company(user_login()->user_id)->row();
      $pm = $this->bm->get($this->table_users, '*', ['ID_company' => $getMainComp->company_id, 'user_role' => 'pm'])->result();

      $data = [
         'app_name'        => APP_NAME,
         'author'          => APP_AUTHOR,
         'title'           => 'Perusahaan',
         'desc'            => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'main_comp'       => $getMainComp,
         'projek_manajer'  => $pm,
         'page'            => 'perusahaan'
      ];
      $this->theme->view('templates/main', 'direktur/perusahaan/index', $data);
   }

   public function show_form() {
      $type = $this->input->post('modal_type');

      if ($type == 'add') {
         $this->load->view('direktur/perusahaan/form_add');
      } else if ($type == 'edit') {
         $company_id = $this->input->post('company_id');
         $parent_id = $this->input->post('parent_id');
         $data['company'] = $this->bm->get($this->table, '*', ['company_id' => $company_id, 'comp_parent_id' => $parent_id])->row();

         $this->load->view('direktur/perusahaan/form_edit', $data);
      }
   }

   public function tambah() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status' => 'validation_error',
            'message' => [
               ['field' => 'comp_name', 'err_message' => form_error('comp_name', '<span>','</span>')],
               ['field' => 'comp_email', 'err_message' => form_error('comp_email', '<span>','</span>')],
               ['field' => 'comp_phone', 'err_message' => form_error('comp_phone', '<span>','</span>')],
               ['field' => 'comp_type', 'err_message' => form_error('comp_type', '<span>','</span>')],
               ['field' => 'comp_since', 'err_message' => form_error('comp_since', '<span>','</span>')]
            ]
         ];
      } else {
         // Initialize Config upload
        $this->upload->initialize($this->_file_upload_config('./uploads/company'));

         if (@$_FILES['comp_logo']['name'] != null) {
            if ($this->upload->do_upload('comp_logo')) {
               $post['logo'] = $this->upload->data('file_name');
               $this->company_model->insert_comp($post);

               if ($this->db->affected_rows() > 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data anak perusahaan telah berhasil disimpan.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data anak perusahaan gagal disimpan.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data anak perusahaan gagal disimpan.'
               ];
            }
         } else {
            $post['logo'] = $this->placeholder;
            $this->company_model->insert_comp($post);
            if ($this->db->affected_rows() > 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data anak perusahaan telah berhasil disimpan.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data anak perusahaan gagal disimpan.'
               ];
            }
         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function edit() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status' => 'validation_error',
            'message' => [
               ['field' => 'comp_name', 'err_message' => form_error('comp_name', '<span>','</span>')],
               ['field' => 'comp_email', 'err_message' => form_error('comp_email', '<span>','</span>')],
               ['field' => 'comp_phone', 'err_message' => form_error('comp_phone', '<span>','</span>')],
               ['field' => 'comp_type', 'err_message' => form_error('comp_type', '<span>','</span>')],
               ['field' => 'comp_since', 'err_message' => form_error('comp_since', '<span>','</span>')]
            ]
         ];
      } else {
         $datacomp = $this->bm->get($this->table, '*', ['company_id' => $post['company_id'], 'comp_parent_id' => $post['comp_parent_id']])->row();

         $this->upload->initialize($this->_file_upload_config('./uploads/company'));
         if (@$_FILES['comp_logo']['name'] != NULL) {
            if ($this->upload->do_upload('comp_logo')) {
               if ($datacomp->comp_logo != $this->placeholder) {
                  unlink('uploads/company/'.base64_decode($post['old']));
               }
               
               $post['comp_logo'] = $this->upload->data('file_name');
               // Update Query
               $this->company_model->update_company($post);
               if ($this->db->affected_rows() >= 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data anak perusahaan telah berhasil diperbarui.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Data anak perusahaan gagal diubah.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Logo gagal diubah. Silahkan periksa ukuran (max 4MB) dan tipe file (JPG, JPEG, PNG)'
               ];
            }
         } else {
            $post['comp_logo'] = $datacomp->comp_logo == $this->placeholder ? $datacomp->comp_logo : base64_decode($post['old']);
            // Update Query
            $this->company_model->update_company($post);
            if ($this->db->affected_rows() >= 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data anak perusahaan telah berhasil diperbarui.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Data anak perusahaan gagal diubah.'
               ];
            }
         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // CRUD Projek Manajer
   public function form_add_mandor() {
      $data['company_id'] = $this->input->post('company_id', TRUE);
      $data['comp_handle_ID'] = $this->input->post('comp_handle_ID', TRUE);
      $data['pageType'] = $this->input->post('pageType', TRUE);

      $this->load->view('direktur/perusahaan/detail/mandor/form_add_mandor', $data, FALSE);
   }

   public function form_edit_mandor() {
      $company_id = $this->input->post('company_id', TRUE);
      $user_unique_id = $this->input->post('user_unique_id', TRUE);

      $data['pageType'] = $this->input->post('pageType', TRUE);
      $data['mandor'] = $this->bm->get($this->table_users, '*', [
         'user_unique_id'  => $user_unique_id, 
         'ID_company'      => $company_id
      ])->row();

      $this->load->view('direktur/perusahaan/detail/mandor/form_edit_mandor', $data, FALSE);
   }

   public function detail_mandor() {
      $unique_id = $this->input->post('unique_id');
      $user_role = $this->input->post('user_role');

      $data['mandor'] = $this->bm->get($this->table_users, '*', [
         'user_unique_id' => $unique_id,
         'user_role'      => $user_role
      ])->row();
      $this->load->view('direktur/perusahaan/detail/mandor/detail_mandor', $data);
   }

   function mandor_process() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      // CRUD Tambah Mandor
      if ($post['pageType'] == 'tambah') {
         $this->form_validation->set_rules($this->_user_rules());
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
            // Generate Mandor Unique ID
            $mdr_ID = getIDCode('MDR',$post['comp_handle_ID']);

            // Initialize Config upload
            $this->upload->initialize($this->_file_upload_config('./uploads/profile')); 
            if (@$_FILES['user_profile']['name'] != NULL) {
               if ($this->upload->do_upload('user_profile')) {
                  $user_prof = $this->upload->data('file_name');

                  $data_insert = [
                     'ID_company'      => $post['ID_company'],
                     'user_unique_id'  => $mdr_ID,
                     'user_role'       => 'employee',
                     'user_role_name'  => 'Mandor',
                     'user_profile'    => $user_prof,
                     'user_fullname'   => $post['user_fullname'],
                     'user_email'      => $post['user_email'],
                     'user_password'   => password_hash($post['user_password'], PASSWORD_DEFAULT),
                     'user_phone'      => $post['user_phone'],
                     'user_address'    => $post['user_address'] == NULL ? NULL : $post['user_address'],
                     'theme_mode'      => 0,
                     'created'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
                  ];

                  $this->bm->save($this->table_users, $data_insert);

                  if ($this->db->affected_rows() > 0) {
                     $message = [
                        'status'    => 'success',
                        'message'   => 'Data Mandor telah berhasil disimpan.'
                     ];
                  } else {
                     $message = [
                        'status'    => 'failed',
                        'message'   => 'Oops! Maaf data Mandor gagal disimpan.'
                     ];
                  }
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data Mandor gagal disimpan.'
                  ];
               }
            } else {
               $user_proff = $this->default_avatar;
               $data_insert = [
                  'ID_company'      => $post['ID_company'],
                  'user_unique_id'  => $mdr_ID,
                  'user_role'       => 'employee',
                  'user_role_name'  => 'Mandor',
                  'user_profile'    => $user_proff,
                  'user_fullname'   => $post['user_fullname'],
                  'user_email'      => $post['user_email'],
                  'user_password'   => password_hash($post['user_password'], PASSWORD_DEFAULT),
                  'user_phone'      => $post['user_phone'],
                  'user_address'    => $post['user_address'] == NULL ? NULL : $post['user_address'],
                  'theme_mode'      => 0,
                  'created'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
               ];

               $this->bm->save($this->table_users, $data_insert);

               if ($this->db->affected_rows() > 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data Mandor telah berhasil disimpan.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data Mandor gagal disimpan.'
                  ];
               }
            }
         }
      } else if ($post['pageType'] == 'edit') {
         $this->form_validation->set_rules($this->_edit_rules());
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
            // Initialize Config upload
            $this->upload->initialize($this->_file_upload_config('./uploads/profile'));
            if (@$_FILES['user_profile']['name'] != NULL) {
               if ($this->upload->do_upload('user_profile')) {
                  if ($post['old_profile'] != $this->default_avatar) {
                     unlink('./uploads/profile/'.$post['old_profile']);
                  }

                  $user_prof = $this->upload->data('file_name');
                  $data_update = [
                     'user_profile'    => $user_prof,
                     'user_fullname'   => $post['user_fullname'],
                     'user_email'      => $post['user_email'],
                     'user_phone'      => $post['user_phone'],
                     'user_address'    => $post['user_address'] == NULL ? NULL : $post['user_address'],
                     'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
                  ];

                  $this->bm->update($this->table_users, $data_update, [
                     'user_unique_id' => $post['user_unique_id'],
                     'ID_company'     => $post['ID_company']
                  ]);

                  if ($this->db->affected_rows() >= 0) {
                     $message = [
                        'status'    => 'success',
                        'message'   => 'Data Mandor telah berhasil diperbarui.'
                     ];
                  } else {
                     $message = [
                        'status'    => 'failed',
                        'message'   => 'Oops! Maaf data Mandor gagal diperbarui.'
                     ];
                  }

               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data Mandor gagal diperbarui.'
                  ];
               }
            } else {
               $user_prof = $post['old_profile'];
               $data_update = [
                  'user_profile'    => $user_prof,
                  'user_fullname'   => $post['user_fullname'],
                  'user_email'      => $post['user_email'],
                  'user_phone'      => $post['user_phone'],
                  'user_address'    => $post['user_address'] == NULL ? NULL : $post['user_address'],
                  'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
               ];

               $this->bm->update($this->table_users, $data_update, [
                  'user_unique_id' => $post['user_unique_id'],
                  'ID_company'     => $post['ID_company']
               ]);

               if ($this->db->affected_rows() >= 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data Mandor telah berhasil diperbarui.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data Mandor gagal diperbarui.'
                  ];
               }
            }

         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}