<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_proyek extends CI_Controller {
   private $tb_project = 'tb_project';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
   }

   private function _file_upload_config($filePath = './assets/img') {
      $config = [
         'upload_path'   => $filePath,
         'allowed_types' => 'jpg|jpeg|png',
         'encrypt_name'  => TRUE
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

   private function _update_progress_by_status($status, $current_progress) {
      $result = '';
      if ($status == 'none' || $status == 'pending') {
         $result = $current_progress;
      } else if ($status == 'onprogress') {
         $result = 50;
      } else if ($status == 'finish'){
         $result = 100;
      }
      return $result;
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
               $thumb = $this->upload->data();
               // Resize Image
               resize_image('./uploads/thumbnail/'.$thumb['file_name']);
               $data['project_thumbnail'] = $thumb['file_name'];
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
               $photo = $this->upload->data();
               // Kalkulasi ukuran foto
               resize_image('./uploads/thumbnail/'.$photo['file_name']);
               $data['project_thumbnail'] = $photo['file_name'];
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
      $project_id = $post['ID_project'];

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
            'ID_project'            => $project_id,
            'ID_priority'           => $post['priority_level'],
            'subproject_name'       => $post['subproject_name'],
            'subproject_deadline'   => $post['subproject_deadline'],
            'subproject_status'     => NULL,
            'subproject_progress'   => 0,
            'panel_color'           => $post['panel_color'],
            'created'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];
         
         $add_subproject = $this->bm->save('tb_subproject', $data);

         if ($add_subproject) {
            
            // Count Total Rows and Progress Subproject
            $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
            $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
               'ID_project'   => $project_id
            ])->row()->total_progress;

            // Current Progress for Main Project
            $proj_progress = $total_sp_progress != '' ? round(intval($total_sp_progress) / intval($total_sp_rows)) : 0;
            $up_project = $this->bm->update('tb_project', [
               'project_progress' => $proj_progress,
               'updated'          => date('Y-m-d H:i:s', now('Asia/Jakarta'))
            ], [
               'project_id'   => $project_id
            ]);

            // Check Project Update
            if ($up_project) {
               
               $message = [
                  'status'    => 'success',
                  'message'   => 'Subprojek telah berhasil disimpan.'
               ];

            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Subproyek gagal ditambahkan.'
               ];
            }
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

   // HAPUS DATA SUBPROYEK
   function hapus_subproyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['subproject_id'];

      $del_subproject = $this->bm->delete('tb_subproject',['subproject_id' => $subproject_id]);

      if ($del_subproject) {
         
         // Count Total Rows and Progress Subproject
         $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
         $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
            'ID_project'   => $project_id
         ])->row()->total_progress;

         // Current Progress for Main Project
         $proj_progress = $total_sp_progress != '' ? round(intval($total_sp_progress) / intval($total_sp_rows)) : 0;

         $up_project = $this->bm->update('tb_project', ['project_progress' => $proj_progress], [
            'project_id'   => $project_id
         ]);

         if ($up_project) {
            $message = [
               'status'    => 'success',
               'message'   => 'Data Subprojek telah berhasil dihapus.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Maaf Sub-Proyek gagal di hapus!'
            ];
         }

      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf Sub-Proyek gagal di hapus!'
         ];
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // TAMBAH DATA SUB-ELEMEN PROYEK
   function tambah_subelemen_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['ID_subproject'];

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
         $add_subelemen = $this->bm->save('tb_project_task', [
            'ID_subproject'         => $subproject_id,
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'project_task_status'   => 'none',
            'project_task_progress' => 0
         ]);

         if ($add_subelemen) {
            // Count Total Rows and Progress Subelemen
            $total_se_rows = $this->ppm->countRows('tb_project_task', ['ID_subproject' => $subproject_id]);
            $total_se_progress = $this->ppm->sumTotalProgress('tb_project_task', 'project_task_progress', 'total_progress', [
                  'ID_subproject'   => $subproject_id
               ])->row()->total_progress;

            // Current Progress for Subproject
            $sp_progress = $total_se_progress != '' ? round(intval($total_se_progress) / intval($total_se_rows)) : 0;
            $up_subproject = $this->bm->update('tb_subproject', ['subproject_progress' => $sp_progress], [
               'subproject_id'   => $subproject_id
            ]);

            if ($up_subproject) {

               // Count Total Rows and Progress Subproject
               $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
               $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
                  'ID_project'   => $project_id
               ])->row()->total_progress;

               // Current Progress for Main Project
               $proj_progress = $total_sp_progress != '' ? round(intval($total_sp_progress) / intval($total_sp_rows)) : 0;

               $up_project = $this->bm->update('tb_project', ['project_progress' => $proj_progress], [
                  'project_id'   => $project_id
               ]);

               if ($up_project) {
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
               
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Sub-elemen proyek gagal disimpan.'
               ];
            }
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
      $project_id = $post['project_id'];
      $subproject_id = $post['ID_subproject'];
      $subelemen_id = $post['project_task_id'];

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
         $progress = $this->_update_progress_by_status($post['project_task_status'], $post['current_progress']);
         $up_subelemen = $this->bm->update('tb_project_task', [
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'project_task_status'   => $post['project_task_status'],
            'project_task_progress' => $progress,
            'updated'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ], [
            'project_task_id' => $subelemen_id, 
            'ID_subproject' => $subproject_id
         ]);

         if ($up_subelemen) {
            // Count Total Rows and Progress Subelemen
            $total_se_rows = $this->ppm->countRows('tb_project_task', ['ID_subproject' => $subproject_id]);
            $total_se_progress = $this->ppm->sumTotalProgress('tb_project_task', 'project_task_progress', 'total_progress', [
                  'ID_subproject'   => $subproject_id
               ])->row()->total_progress;

            // Current Progress for Subproject
            $sp_progress = round(intval($total_se_progress) / intval($total_se_rows));

            $up_subproject = $this->bm->update('tb_subproject', ['subproject_progress' => $sp_progress], [
               'subproject_id'   => $subproject_id
            ]);

            if ($up_subproject) {
               // Count Total Rows and Progress Subproject
               $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
               $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
                  'ID_project'   => $project_id
               ])->row()->total_progress;

               // Current Progress for Main Project
               $proj_progress = round(intval($total_sp_progress) / intval($total_sp_rows));

               $up_project = $this->bm->update('tb_project', ['project_progress' => $proj_progress], [
                  'project_id'   => $project_id
               ]);

               if ($up_project) {
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

            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Sub-elemen proyek gagal diperbarui.'
               ];
            }

         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Sub-elemen proyek gagal diperbarui.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // HAPUS DATA SUB-EMEMEN PROYEK
   function hapus_subelemen_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['subproject_id'];
      $subelemen_id = $post['subelemen_id'];

      $del_subelemen = $this->bm->delete('tb_project_task',[
         'project_task_id' => $subelemen_id
      ]);

      if ($del_subelemen) {
         // Count Total Rows and Progress Subelemen
         $total_se_rows = $this->ppm->countRows('tb_project_task', ['ID_subproject' => $subproject_id]);
         $total_se_progress = $this->ppm->sumTotalProgress('tb_project_task', 'project_task_progress', 'total_progress', [
               'ID_subproject'   => $subproject_id
            ])->row()->total_progress;

         // Current Progress for Subproject
         $sp_progress = $total_se_progress != '' ? round(intval($total_se_progress) / intval($total_se_rows)) : 0;

         $up_subproject = $this->bm->update('tb_subproject', ['subproject_progress' => $sp_progress], [
            'subproject_id'   => $subproject_id
         ]);

         if ($up_subproject) {
            
            // Count Total Rows and Progress Subproject
            $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
            $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
               'ID_project'   => $project_id
            ])->row()->total_progress;

            // Current Progress for Main Project
            $proj_progress = $total_sp_progress != '' ? round(intval($total_sp_progress) / intval($total_sp_rows)) : 0;

            $up_project = $this->bm->update('tb_project', ['project_progress' => $proj_progress], [
               'project_id'   => $project_id
            ]);

            if ($up_project) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data Sub-elemen / list proyek telah berhasil Dihapus.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Sub-elemen / list proyek gagal dihapus.'
               ];
            }

         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Sub-elemen / list proyek gagal dihapus.'
            ];
         }

      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Sub-elemen / list proyek gagal dihapus.'
         ];
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   // UPLOAD DOKUMENTASI
   function upload_dokumentasi() {
      $data = [];
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $countPhoto = count($_FILES['project_photo']['name']);
      $pathUpload = '';
      if ($post['type_pro'] == 'proyek') {
         $pathUpload = 'project_doc';
      } else if ($post['type_pro'] == 'subproyek'){
         $pathUpload = 'subproject_doc';
      }

      for ($i = 0; $i < $countPhoto; $i++) {
         if (isset($_FILES['project_photo']['name'][$i])) {
            $_FILES['photo']['name']      = $_FILES['project_photo']['name'][$i];
            $_FILES['photo']['type']      = $_FILES['project_photo']['type'][$i];
            $_FILES['photo']['tmp_name']  = $_FILES['project_photo']['tmp_name'][$i];
            $_FILES['photo']['error']     = $_FILES['project_photo']['error'][$i];
            $_FILES['photo']['size']      = $_FILES['project_photo']['size'][$i];
            
            $this->upload->initialize($this->_file_upload_config('./uploads/'.$pathUpload));
            if (!$this->upload->do_upload('photo')) {
               // Error
               $message[$i] = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf gambar gagal diupload. Silahkan cek kembali koneksi atau file yang akan diupload!',
                  'errors'    => ['error' => $this->upload->display_errors()]
               ];
            } else {
               // Get upload data
               $photo = $this->upload->data();
               // Compress File Size
               resize_image('./uploads/'.$pathUpload.'/'.$photo['file_name']);

               // Store the data into array variable
               $data[] = [
                  'ID_project'      => $post['proj_id'],
                  'ID_subproject'   => $post['subproj_id'] == '' ? NULL : $post['subproj_id'],
                  'photo_url'       => $pathUpload.'/'.$photo['file_name'],
                  'created'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
               ];
            }
         }
      }

      // Save Photo to database
      $this->bm->save('tb_photo', $data, TRUE);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => $countPhoto.' Gambar telah berhasil diupload'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf gambar gagal diupload. Silahkan cek kembali koneksi atau file yang akan diupload!'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function hapus_foto_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->bm->delete('tb_photo', [
         'photo_id'     => $post['photo_id'],
         'ID_project'   => $post['project_id']
      ]);
      unlink('./uploads/'.$post['photo_url']);
      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Gambar telah telah terhapus.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf gambar gagal dihapus.'
         ];
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function hapus_foto_subproyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->bm->delete('tb_photo', [
         'photo_id'        => $post['photo_id'],
         'ID_project'      => $post['project_id'],
         'ID_subproject'   => $post['subproject_id']
      ]);
      unlink('./uploads/'.$post['photo_url']);
      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Gambar telah telah terhapus.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf gambar gagal dihapus.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function tinjau_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->bm->update('tb_project', [
         'project_status'  => 'review',
         'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta')) 
      ], [
         'project_id'   => $post['project_id'],
         'ID_pm'        => $post['ID_pm'],
         'ID_company'   => $post['ID_company']
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek sedang ditinjau oleh direktur.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! maaf terjadi kesalahan, silahkan periksa koneksi/jaringan anda, lalu coba lagi.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function revisi_proyek() {
      $message = [];
      $project_id = $this->input->post('project_id', TRUE);
      $this->bm->update('tb_project', [
         'project_status'  => 'revision',
         'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ], ['project_id'   => $project_id]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek sedang direvisi kembali.',
            'redirect'  => site_url('pm/riwayat')
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! maaf terjadi kesalahan, silahkan periksa koneksi/jaringan anda, lalu coba lagi.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}