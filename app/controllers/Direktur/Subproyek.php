<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subproyek extends CI_Controller {
   private $tb_subproject = 'tb_subproject';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      unset_chat_session();
      $this->load->model('project_model');
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

   public function form_tambah_subproyek() {
      $data['project_id']  = $this->input->post('project_id', TRUE);
      $data['data_priority']    = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('direktur/proyek/detail/subproyek/modal_add_form', $data);
   }

   public function form_edit_subproyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['data_priority']    = $this->bm->get('tb_priority', '*')->result();
      $data['subproject'] = $this->bm->get($this->tb_subproject, '*', [
         'subproject_id' => $subproject_id, 
         'ID_project' => $project_id
      ])->row();
      $this->load->view('direktur/proyek/detail/subproyek/modal_edit_form', $data);
   }

   function tambah() {
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
            'panel_color'           => $post['panel_color']
         ];

         $add_subproject = $this->bm->save($this->tb_subproject, $data);
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

   function edit() {
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
         $this->bm->update($this->tb_subproject, $data, [
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

   // function hapus() {
   //    $message = [];
   //    $post = $this->input->post(NULL, TRUE);
   //    $project_id = $post['project_id'];
   //    $subproject_id = $post['subproject_id'];

   //    $del_subproject = $this->bm->delete($this->tb_subproject,['subproject_id' => $subproject_id]);
   //    if ($del_subproject) {
   //       // Count Total Rows and Progress Subproject
   //       $total_sp_rows = $this->ppm->countRows('tb_subproject', ['ID_project' => $project_id]);
   //       $total_sp_progress = $this->ppm->sumTotalProgress('tb_subproject', 'subproject_progress', 'total_progress', [
   //          'ID_project'   => $project_id
   //       ])->row()->total_progress;

   //       // Current Progress for Main Project
   //       $proj_progress = $total_sp_progress != '' ? round(intval($total_sp_progress) / intval($total_sp_rows)) : 0;
   //       $up_project = $this->bm->update('tb_project', ['project_progress' => $proj_progress], [
   //          'project_id'   => $project_id
   //       ]);

   //       if ($up_project) {
   //          $message = [
   //             'status'    => 'success',
   //             'message'   => 'Data Subprojek telah berhasil dihapus.'
   //          ];
   //       } else {
   //          $message = [
   //             'status'    => 'failed',
   //             'message'   => 'Oops! Maaf Sub-Proyek gagal di hapus!'
   //          ];
   //       }
   //    } else {
   //       $message = [
   //          'status'    => 'failed',
   //          'message'   => 'Oops! Maaf Sub-Proyek gagal di hapus!'
   //       ];
   //    }

   //    $this->output->set_content_type('application/json')->set_output(json_encode($message));
   // }
}