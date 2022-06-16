<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_proyek extends CI_Controller {
   private $tb_project = 'tb_project';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
      $this->load->model('projectpm_model');
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
            'field'  => 'project_name',
            'label'  => 'Nama proyek',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'project_start',
            'label'  => 'Tanggal',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib Diisi.'
            ]
         ],
         [
            'field'  => 'project_deadline',
            'label'  => 'Tanggal',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib Diisi.'
            ]
         ]
      ];
      return $config;
   }

   private function _rule_subproyek() {
      $config = [
         [
            'field'  => 'subproject_name',
            'label'  => 'Nama Subproyek',
            'rules'  => 'trim|required',
            'errors' => [
               'required'  => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'subproject_deadline',
            'label'  => 'Deadline Subproyek',
            'rules'  => 'trim|required',
            'errors' => [
               'required'  => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'priority_level',
            'label'  => 'Level prioritas Subproyek',
            'rules'  => 'trim|required',
            'errors' => [
               'required'  => '{field} wajib diisi.'
            ]
         ]
      ];
      return $config;
   }

   private function _rule_subelemen_proyek() {
      $config = [
         [
            'field'  => 'project_task_name',
            'label'  => 'Nama Sub-elemen',
            'rules'  => 'trim|required',
            'errors' => [
               'required'  => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'project_task_deadline',
            'label'  => 'Deadline',
            'rules'  => 'trim|required',
            'errors' => [
               'required'  => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'task_priority_level',
            'label'  => 'Level prioritas',
            'rules'  => 'trim|required',
            'errors' => [
               'required'  => '{field} wajib diisi.'
            ]
         ]
      ];
      return $config;
   }

   // TAMBAH DATA MANAJEMEN PROYEK UTAMA
   function tambah_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'project_name', 'err_message' => form_error('project_name', '<span>','</span>')],
               ['field' => 'project_start', 'err_message' => form_error('project_start', '<span>','</span>')],
               ['field' => 'project_deadline', 'err_message' => form_error('project_deadline', '<span>','</span>')],
            ]
         ];
      } else {
         $data = [
            'ID_pm'                 => user_login()->user_id,
            'ID_company'            => user_company()->company_id,
            'project_code_ID'       => $this->str_secure->decryptid($post['project_code_ID']),
            'project_name'          => $post['project_name'],
            'project_address'       => $post['project_address'],
            'project_description'   => $post['project_description'],
            'project_start'         => $post['project_start'],
            'project_deadline'      => $post['project_deadline'],
            'project_current_deadline' => NULL,
            'project_deadline_month'   => NULL,
            'project_status'        => 'none',
            'project_progress'      => 0,
            'project_archive'       => '0',
            'created'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         $this->upload->initialize($this->_file_upload_config('./uploads/thumbnail'));

         if (@$_FILES['thumbnail_image']['name'] != NULL) {
            if ($this->upload->do_upload('thumbnail_image')) {
               $data['project_thumbnail'] = $this->upload->data('file_name');
               $this->bm->save('tb_project', $data);
               if ($this->db->affected_rows() > 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data proyek berhasil tersimpan'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data proyek gagal disimpan.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Gagal Upload gambar.'
               ];
            }
         } else {
            $data['project_thumbnail'] = 'placeholder.jpg';
            $this->bm->save('tb_project', $data);
            if ($this->db->affected_rows() > 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data proyek berhasil tersimpan'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data proyek gagal disimpan.'
               ];
            }
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // TAMBAH DATA MANAJEMEN SUB-PROYEK
   function edit_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'project_name', 'err_message' => form_error('project_name', '<span>','</span>')],
               ['field' => 'project_start', 'err_message' => form_error('project_start', '<span>','</span>')],
               ['field' => 'project_deadline', 'err_message' => form_error('project_deadline', '<span>','</span>')],
            ]
         ];
      } else {
         $data = [
            'project_name'          => $post['project_name'],
            'project_address'       => $post['project_address'],
            'project_description'   => $post['project_description'],
            'project_start'         => $post['project_start'],
            'project_deadline'      => $post['project_deadline'],
            'updated'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         $this->upload->initialize($this->_file_upload_config('./uploads/thumbnail'));
         // File Upload
         if (@$_FILES['profile_image']['name'] != NULL) {
            if ($this->upload->do_upload('profile_image')) {
               if ($post['old_thumbnail'] != 'placeholder.jpg') {
                  unlink('./uploads/thumbnail/'.$post['old_thumbnail']);
               }
               $data['project_thumbnail'] = $this->upload->data('file_name');
               $this->bm->update($this->tb_project, $data, [
                  'project_code_ID' => $post['project_code_ID'],
                  'ID_pm'           => user_login()->user_id
               ]);
               if ($this->db->affected_rows() >= 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data proyek berhasil Diperbarui.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data proyek gagal Diperbarui.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data proyek gagal Diperbarui.'
               ];
            }
         } else {
            $data['project_thumbnail'] = $post['old_thumbnail'];
            $this->bm->update($this->tb_project, $data, [
               'project_code_ID' => $post['project_code_ID'],
               'ID_pm'           => user_login()->user_id
            ]);
            if ($this->db->affected_rows() >= 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data proyek berhasil Diperbarui.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data proyek gagal Diperbarui.'
               ];
            }
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // TAMBAH DATA SUBPROYEK
   function tambah_subproyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rule_subproyek());

      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'subproject_name', 'err_message' => form_error('subproject_name', '<span>','</span>')],
               ['field' => 'subproject_deadline', 'err_message' => form_error('subproject_deadline', '<span>','</span>')],
               ['field' => 'priority_level', 'err_message' => form_error('priority_level', '<span>','</span>')]
            ]
         ];
      } else {
         $data = [
            'ID_project'            => $post['ID_project'],
            'ID_priority'           => $post['priority_level'],
            'subproject_name'       => $post['subproject_name'],
            'subproject_deadline'   => $post['subproject_deadline'],
            'subproject_status'     => NULL,
            'subproject_progress'   => 0,
            'panel_color'           => $post['panel_color']
         ];
         $this->bm->save('tb_subproject', $data);

         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Subproyek berhasil ditambahkan.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Subproyek gagal ditambahkan.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // EDIT SUBPROYEK
   function edit_subproyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rule_subproyek());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'subproject_name', 'err_message' => form_error('subproject_name', '<span>','</span>')],
               ['field' => 'subproject_deadline', 'err_message' => form_error('subproject_deadline', '<span>','</span>')],
               ['field' => 'priority_level', 'err_message' => form_error('priority_level', '<span>','</span>')]
            ]
         ];
      } else {
         $data = [
            'ID_priority'         => $post['priority_level'],
            'subproject_name'     => $post['subproject_name'],
            'subproject_deadline' => $post['subproject_deadline'],
            'panel_color'         => $post['panel_color'],
            'updated'             => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];
         $this->bm->update('tb_subproject', $data, [
            'subproject_id' => $post['subproject_id'], 
            'ID_project' => $post['ID_project']
         ]);
         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Subproyek berhasil diperbarui.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Subproyek gagal diperbarui.'
            ];
         }  
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // TAMBAH DATA SUB-ELEMEN PROYEK
   function tambah_subelemen_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->form_validation->set_rules($this->_rule_subelemen_proyek());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'project_task_name', 'err_message' => form_error('project_task_name', '<span>','</span>')],
               ['field' => 'project_task_deadline', 'err_message' => form_error('project_task_deadline', '<span>','</span>')],
               ['field' => 'task_priority_level', 'err_message' => form_error('task_priority_level', '<span>','</span>')]
            ]
         ];
      } else {
         $data = [
            'ID_subproject'         => $post['ID_subproject'],
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'project_task_status'   => 'none',
            'project_task_progress' => 0
         ];
         $this->bm->save('tb_project_task', $data);

         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Sub-elemen proyek berhasil disimpan.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Sub-elemen proyek gagal disimpan.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // EDIT DATA SUB-ELEMEN PROYEK
   function edit_subelemen_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rule_subelemen_proyek());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status'    => 'validation_error',
            'message'   => [
               ['field' => 'project_task_name', 'err_message' => form_error('project_task_name', '<span>','</span>')],
               ['field' => 'project_task_deadline', 'err_message' => form_error('project_task_deadline', '<span>','</span>')],
               ['field' => 'task_priority_level', 'err_message' => form_error('task_priority_level', '<span>','</span>')]
            ]
         ];
      } else {
         $progress = '';
         if ($post['project_task_status'] == 'none' || $post['project_task_status'] == 'pending') {
            $progress = $post['current_progress'];
         } else if ($post['project_task_status'] == 'onprogress') {
            $progress = 50;
         } else if ($post['project_task_status'] == 'finish'){
            $progress = 100;
         }

         $data = [
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'project_task_status'   => $post['project_task_status'],
            'project_task_progress' => $progress,
            'updated'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         $this->bm->update('tb_project_task', $data, [
            'project_task_id' => $post['project_task_id'], 
            'ID_subproject' => $post['ID_subproject']
         ]);

         if ($this->db->affected_rows() >= 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Sub-elemen proyek berhasil diperbarui.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Sub-elemen proyek gagal diperbarui.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function hapus() {
      $message = [];
      $list_type = $this->input->post('task_type', TRUE);
      $id_sub = $this->input->post('id_sub', TRUE);
      $project_id = $this->input->post('project_id', TRUE);

      if ($list_type == 'subproject') {
         $this->bm->delete('tb_subproject', ['subproject_id' => $id_sub, 'ID_project' => $project_id]);
         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Sub-project telah berhasil dihapus.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Sub-project gagal dihapus.'
            ];
         }
      } else if ($list_type == 'sub_elemen') {
         $this->bm->delete('tb_project_task', ['project_task_id' => $id_sub]);
         if ($this->db->affected_rows() > 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Sub-project telah berhasil dihapus.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Sub-project gagal dihapus.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // UPLOAD DOKUMENTASI
   function upload_dokumentasi() {
      $post = $this->input->post(NULL, TRUE);
      $countPhoto = count($_FILES['project_photo']['name']);

      // for ($i = 0; $i < $countPhoto; $i++) {
         
         

      // }

      $message = [
         'status'       => ['success', 'failed', 'validation_error'],
         'data'         => $post,
         'total_photos' => $countPhoto,
         'photos'       => $_FILES['project_photo']
      ];
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}