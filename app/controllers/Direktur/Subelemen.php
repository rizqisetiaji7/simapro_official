<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subelemen extends CI_Controller {
   private $tb_subelemen = 'tb_project_task';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      unset_chat_session();
      $this->load->model('project_model');
   }

   private function _rule_subelemen() {
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

   public function form_tambah_subelemen() {
      $data['subproject_id']  = $this->input->post('subproject_id', TRUE);
      $data['project_id']     = $this->input->post('project_id', TRUE);
      $data['priority']       = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('direktur/proyek/detail/subelemen/form_add_subelemen', $data);
   }

   public function form_edit_subelemen() {
      $subelemen_id = $this->input->post('subelemen_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['subelemen'] = $this->bm->get($this->tb_subelemen, '*', [
         'project_task_id' => $subelemen_id,
         'ID_subproject' => $subproject_id
      ])->row();
      $data['priority'] = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('direktur/proyek/detail/subelemen/form_edit_subelemen', $data);
   }

   function tambah() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['ID_subproject'];

      $this->form_validation->set_rules($this->_rule_subelemen());
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
         $add_subelemen = $this->bm->save($this->tb_subelemen, [
            'ID_subproject'         => $subproject_id,
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'project_task_status'   => 'none',
            'project_task_progress' => 0
         ]);

         if ($add_subelemen) {
            // Count Total Rows and Progress Subelemen
            $total_se_rows = $this->ppm->countRows($this->tb_subelemen, ['ID_subproject' => $subproject_id]);
            $total_se_progress = $this->ppm->sumTotalProgress($this->tb_subelemen, 'project_task_progress', 'total_progress', [
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

   function edit() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $subproject_id = $post['ID_subproject'];
      $subelemen_id = $post['project_task_id'];

      $this->form_validation->set_rules($this->_rule_subelemen());
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
         $this->bm->update($this->tb_subelemen, [
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'updated'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ], [
            'project_task_id' => $subelemen_id, 
            'ID_subproject'   => $subproject_id
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

   // function hapus() {
   //    $message = [];
   //    $post = $this->input->post(NULL, TRUE);
   //    $project_id = $post['project_id'];
   //    $subproject_id = $post['subproject_id'];
   //    $subelemen_id = $post['subelemen_id'];

   //    $del_subelemen = $this->bm->delete($this->tb_subelemen, [
   //       'project_task_id' => $subelemen_id
   //    ]);

   //    if ($del_subelemen) {
   //       // Count Total Rows and Progress Subelemen
   //       $total_se_rows = $this->ppm->countRows($this->tb_subelemen, ['ID_subproject' => $subproject_id]);
   //       $total_se_progress = $this->ppm->sumTotalProgress($this->tb_subelemen, 'project_task_progress', 'total_progress', [
   //             'ID_subproject'   => $subproject_id
   //          ])->row()->total_progress;

   //       // Current Progress for Subproject
   //       $sp_progress = $total_se_progress != '' ? round(intval($total_se_progress) / intval($total_se_rows)) : 0;
   //       $up_subproject = $this->bm->update('tb_subproject', ['subproject_progress' => $sp_progress], [
   //          'subproject_id'   => $subproject_id
   //       ]);

   //       if ($up_subproject) {
   //          // Count Total Rows and Progress Subproject
   //          $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
   //          $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
   //             'ID_project'   => $project_id
   //          ])->row()->total_progress;

   //          // Current Progress for Main Project
   //          $proj_progress = $total_sp_progress != '' ? round(intval($total_sp_progress) / intval($total_sp_rows)) : 0;
   //          $up_project = $this->bm->update('tb_project', ['project_progress' => $proj_progress], [
   //             'project_id'   => $project_id
   //          ]);

   //          if ($up_project) {
   //             $message = [
   //                'status'    => 'success',
   //                'message'   => 'Data Sub-elemen / list proyek telah berhasil Dihapus.'
   //             ];
   //          } else {
   //             $message = [
   //                'status'    => 'failed',
   //                'message'   => 'Oops! Sub-elemen / list proyek gagal dihapus.'
   //             ];
   //          }
   //       } else {
   //          $message = [
   //             'status'    => 'failed',
   //             'message'   => 'Oops! Sub-elemen / list proyek gagal dihapus.'
   //          ];
   //       }
   //    } else {
   //       $message = [
   //          'status'    => 'failed',
   //          'message'   => 'Oops! Sub-elemen / list proyek gagal dihapus.'
   //       ];
   //    }
   //    $this->output->set_content_type('application/json')->set_output(json_encode($message));
   // }
}