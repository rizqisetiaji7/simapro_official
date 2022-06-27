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

   function hapus() {
      $message = [];
      $list_type = $this->input->post('task_type', TRUE);
      $id_sub = $this->input->post('id_sub', TRUE);
      $project_id = $this->input->post('project_id', TRUE);

      if ($list_type == 'subproject') {
         // Delete Sub-elemen
         $subElemen = $this->bm->get('tb_project_task', '*', ['ID_subproject' => $id_sub]);
         if ($subElemen->num_rows() > 0) {
            $this->bm->delete('tb_project_task', ['ID_subproject' => $id_sub]);
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
         } else {
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

   // Dokumentasi Foto Proyek Utama
   function tampil_dokumentasi_proyek() {
      $project_id = $this->input->post('project_id');
      $data['docs'] =$this->project_model->get_documentation_project($project_id);
      $this->load->view('direktur/proyek/detail/foto_dokumentasi_proyek', $data);
   }

   // Dokumentasi Foto Proyek Utama
   function tampil_dokumentasi_subproyek() {
      $project_id = $this->input->post('project_id');
      $subproject_id = $this->input->post('subproject_id');
      $data['docs'] =$this->project_model->get_documentation_subproject($project_id, $subproject_id);
      $this->load->view('direktur/proyek/detail/foto_dokumentasi_subproyek', $data);
   }

   // Status Proyek Telah Selesai
   function status_proyek_selesai() {
      $message = [];
      $project_id = $this->input->post('project_id', TRUE);

      $this->bm->update('tb_project', [
         'project_current_deadline' => date('Y-m-d', now('Asia/Jakarta')),
         'project_deadline_month'   => date('Y-m', now('Asia/Jakarta')),
         'project_status'           => 'finish',
         'updated'                  => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ], [
         'project_id'   => $project_id
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek yang telah anda kerjakan telah selesai.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oop! Terjadi kesalahan, coba lagi beberapa saat.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}