<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
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

   function form_tambah_subproyek() {
      $data['project_id']  = $this->input->post('project_id');
      $data['data_priority']    = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('direktur/proyek/detail_proyek/subproyek/modal_add_form', $data);
   }

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

   function form_edit_subproyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['data_priority']    = $this->bm->get('tb_priority', '*')->result();
      $data['subproject'] = $this->bm->get('tb_subproject', '*', ['subproject_id' => $subproject_id, 'ID_project' => $project_id])->row();
      $this->load->view('direktur/proyek/detail_proyek/subproyek/modal_edit_form', $data);
   }

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
            // 'subproject_status'   => NULL,
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

   // SUB-ELEMEN PROYEK
   function form_tambah_subelemen_proyek() {
      $data['subproject_id']  = $this->input->post('subproject_id', TRUE);
      $data['priority']       = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('direktur/proyek/detail_proyek/subelemen_proyek/modalsubelemen_add_form', $data);
   }

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
            'project_task_status'   => NULL,
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

   function form_edit_subelemen_proyek() {
      $subelemen_id = $this->input->post('subelemen_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['subelemen'] = $this->bm->get('tb_project_task', '*', [
         'project_task_id' => $subelemen_id,
         'ID_subproject' => $subproject_id
      ])->row();
      $data['priority'] = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('direktur/proyek/detail_proyek/subelemen_proyek/modalsubelemen_edit_form', $data);
   }

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
         if ($post['project_task_status'] == 'onprogress') {
            $progress = 50;
         } else if ($post['project_task_status'] == 'finish') {
            $progress = 100;
         } else if ($post['project_task_status'] == '') {
            $progress = 0;
         } else {
            $progress = $post['current_progress'];
         }

         $data = [
            'ID_priority'           => $post['task_priority_level'],
            'project_task_name'     => $post['project_task_name'],
            'project_task_deadline' => $post['project_task_deadline'],
            'project_task_status'   => $post['project_task_status'],
            'project_task_progress' => $progress,
            'updated'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];

         $this->bm->update('tb_project_task', $data, ['project_task_id' => $post['project_task_id'], 'ID_subproject' => $post['ID_subproject']]);

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
   //    echo 'Hapus';
   // }
}