<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
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

   protected function tampil_proyek($limit) {
      $comp_id = user_company()->company_id;
      $pm_id = user_company()->user_id;
      return $this->ppm->get_pm_projects($comp_id, $pm_id, $limit)->result();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Daftar proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $this->tampil_proyek(20),
         'page'      => 'proyek'
      ];
      $this->theme->view('templates/main', 'pm/proyek/daftar/index', $data);
   }

   public function detail() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Proyek Detail',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_detail'
      ];
      $this->theme->view('templates/main', 'pm/proyek/detail/index', $data);
   }

   public function arsip() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Arsip Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_arsip'
      ];
      $this->theme->view('templates/main', 'pm/proyek/arsip/index', $data);
   }

   public function riwayat() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_riwayat'
      ];
      $this->theme->view('templates/main', 'pm/proyek/riwayat/index', $data);
   }


   // ============= CRUD ============= //

   public function tambah_proyek() {
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
            'project_status'        => 'on_progress',
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

   function update_status_proyek() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->bm->update('tb_project', ['project_status' => $post['project_status']],[
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

   function arsip_proyek() {
      $message = [];
      $code_id = $this->input->post('project_code', TRUE);
      $this->bm->update('tb_project', ['project_archive' => 1], ['project_code_ID' => $code_id]);
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

   // =========== END CRUD =========== //

   function form_tambah_proyek() {
      $data['project_code_ID'] = getIDCode('PROY', user_company()->comp_prefix);
      $this->load->view('pm/proyek/daftar/form/tambah_proyek', $data);
   }

   function form_update_status() {
      $id = $this->input->post('project_code', TRUE);
      $data['project_status'] = $this->bm->get('tb_project', 'project_id, ID_pm, ID_company, project_code_ID, project_progress, project_status', ['project_code_ID' => $id])->row();
      $this->load->view('pm/proyek/daftar/form/update_status', $data);
   }

   function tampil_form_edit_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/form_edit_proyek');
   }

   function tampil_form_edit_status_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/form_edit_status_proyek');
   }

   function tampil_foto_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/foto_dokumentasi_proyek');
   }

   function tampil_foto_subproyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/foto_dokumentasi_subproyek');
   }

   function tampil_form_tambah_subproyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subproyek/modal_add_form');
   }

   function tampil_form_edit_subproyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subproyek/modal_edit_form');
   }

   function form_tambah_subelemen_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subelemen/modalsubelemen_add_form');
   }

   function form_edit_subelemen_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/subelemen/modalsubelemen_edit_form');
   }
}