<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   private $tb_project = 'tb_project';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
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

   public function index() {
      $projects = $this->project_model->get_all_user_project(user_login()->ID_company)->result();
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Daftar Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $projects,
         'page'      => 'daftar_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/daftar_proyek/index', $data);
   }

   function form_edit_status() {
      $id = $this->input->post('project_code', TRUE);
      $data['project_status'] = $this->bm->get($this->tb_project, 'project_id, ID_pm, ID_company, project_code_ID, project_progress, project_status', ['project_code_ID' => $id])->row();
      $this->load->view('direktur/proyek/daftar_proyek/form_edit_status', $data);
   }

   function edit_status_process() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->bm->update($this->tb_project, ['project_status' => $post['project_status']],[
         'project_code_ID' => $post['project_code_ID']
      ]);
      if ($this->db->affected_rows() >= 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Status berhasil diperbarui.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Status gagal diperbarui.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function form_tambah() {
      $data['project_code_ID'] = urlencode(base64_encode(getIDCode('PROY', user_company()->comp_prefix)));
      $data['project_man'] = $this->bm->get('tb_users', 'user_id, user_fullname', ['ID_company' => user_company()->company_id, 'user_role' => 'pm'])->result();
      $this->load->view('direktur/proyek/daftar_proyek/form_tambah_proyek', $data);
   }

   // CRUD List Proyek
   function tambah() {
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
            'ID_pm'                 => $post['ID_pm'] == '' ? NULL : $post['ID_pm'],
            'ID_company'            => user_company()->company_id,
            'project_code_ID'       => urldecode(base64_decode($post['project_code_ID'])),
            'project_name'          => $post['project_name'],
            'project_address'       => $post['project_address'],
            'project_description'   => $post['project_description'],
            'project_start'         => $post['project_start'],
            'project_deadline'      => $post['project_deadline'],
            'project_progress'      => 0,
            'project_archive'       => '0',
            'created'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];
         
         $this->upload->initialize($this->_file_upload_config('./uploads/thumbnail'));
         // Upload File Thumbnail Image
         if (@$_FILES['profile_image']['name'] != NULL) {
            if ($this->upload->do_upload('profile_image')) {
               $data['project_thumbnail'] = $this->upload->data('file_name');
               $this->bm->save($this->tb_project, $data);

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
                  'message'   => 'Oops! Maaf data proyek gagal disimpan.'
               ];
            }
         } else {
            $data['project_thumbnail'] = 'placeholder.jpg';
            $this->bm->save($this->tb_project, $data);
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

   public function riwayat_proyek() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'riwayat_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/riwayat', $data);
   }

   public function arsip_proyek() {
      $archived = $this->project_model->get_project_archive(user_company()->company_id)->result();
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'archived'  => $archived,
         'page'      => 'arsip_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/arsip/index', $data);
   }

   function arsip_process() {
      $message = [];
      $code_id = urldecode(base64_decode($this->input->post('project_code', TRUE)));
      $this->bm->update($this->tb_project, ['project_archive' => 1], ['project_code_ID' => $code_id]);
      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek telah berhasil diarsipkan.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Proyek gagal disimpan sebagai arsip'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function hapus_arsip() {
      $message = [];
      $project_ID = $this->input->post('project_ID', TRUE);
      $this->bm->update($this->tb_project, [
         'project_archive' => '0', 
         'project_status' => 'on_progress'
      ], [
         'project_code_ID' => $project_ID
      ]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek telah berhasil dikembalikan ke daftar proyek.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Proses gagal, silahkan coba lagi!'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function detail_proyek($company_id, $project_code_ID) {
      $project = $this->project_model->get_project_detail($company_id, $project_code_ID)->row();
      $subproject = $this->project_model->get_subproject([
         'ID_project' => $project->project_id
      ]);

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => 'Detail Proyek',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'project'      => $project,
         'subproject'   => $subproject,
         'page'         => 'detail_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/detail_proyek/index', $data);
   }

   public function form_edit_proyek() {
      $code_ID = $this->input->post('project_code_ID', TRUE);
      $project = $this->project_model->get_project_detail(user_company()->company_id, $code_ID)->row();
      $project_manajer = $this->bm->get('tb_users', '*', [
         'ID_company' => $project->company_id, 
         'user_role' => 'pm'
      ])->result();

      $data = [
         'project'         => $project,
         'project_manajer' => $project_manajer
      ];

      $this->load->view('direktur/proyek/detail_proyek/form_edit_proyek', $data);
   }

   public function edit_detail_proyek() {
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
            'ID_pm'                 => $post['ID_pm'] == '' ? NULL : $post['ID_pm'],
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
               $this->bm->update($this->tb_project, $data, ['project_code_ID' => $post['project_code_ID']]);
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
            $this->bm->update($this->tb_project, $data, ['project_code_ID' => $post['project_code_ID']]);
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
}