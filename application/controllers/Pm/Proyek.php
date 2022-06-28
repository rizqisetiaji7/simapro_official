<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   private $tb_project = 'tb_project';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
      unset_chat_session();
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

   protected function tampil_proyek($limit) {
      $comp_id = user_company()->company_id;
      $pm_id = user_company()->user_id;
      return $this->ppm->get_pm_projects($comp_id, $pm_id, $limit)->result();
   }

   protected function tampil_subproyek($project_id) {
      return $this->ppm->get_subprojectpm($project_id)->result_array();
   }

   protected function data_detail_proyek($comp_id, $project_code, $pm_id) {
      return $this->ppm->get_projectpm_detail($comp_id, $project_code, $pm_id)->row();
   }

   protected function _direktur($company_id='') {
      return $this->bm->get('tb_users', '*', ['ID_company' => $company_id, 'user_role' => 'direktur'])->row();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(PM) Daftar proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $this->tampil_proyek(25),
         'page'      => 'proyek'
      ];
      $this->theme->view('templates/main', 'pm/proyek/daftar/index', $data);
   }

   public function detail($comp_id, $project_code) {
      $project    = $this->data_detail_proyek($comp_id, $project_code, user_login()->user_id);
      $subproject = $this->tampil_subproyek($project->project_id);
      $docs       = $this->ppm->get_documentation($project->project_id, NULL);
      $direktur   = $this->_direktur(user_company()->company_id);
      
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(PM) Proyek Detail',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_detail',
         'direktur'  => $direktur,
         'docs'      => $docs
      ];

       $data['project'] = [
         'project_id'            => $project->project_id,
         'ID_pm'                 => $project->user_id,
         'ID_company'            => $project->company_id,
         'projectID'             => $project->projectID,
         'project_name'          => $project->project_name,
         'project_thumbnail'     => $project->project_thumbnail,
         'project_description'   => $project->project_description,
         'project_start'         => $project->project_start,
         'project_deadline'      => $project->project_deadline,
         'project_status'        => $project->project_status,
         'project_progress'      => $project->project_progress,
         'project_address'       => $project->project_address,
         'project_archive'       => $project->project_archive,
         'user_role'             => $project->user_role,
         'user_fullname'         => $project->user_fullname,
         'user_profile'          => $project->user_profile,
         'comp_name'             => $project->comp_name,
         'subproject'            => $subproject
      ];
      $this->theme->view('templates/main', 'pm/proyek/detail/index', $data);
   }

   // ============= CRUD ============= //

   // TAMBAH DATA MANAJEMEN PROYEK UTAMA
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

   public function edit_proyek() {
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

   public function update_status_proyek() {
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

   // =========== END CRUD =========== //

   public function form_tambah_proyek() {
      $data['project_code_ID'] = getIDCode('PROY', user_company()->comp_prefix);
      $this->load->view('pm/proyek/daftar/form/tambah_proyek', $data);
   }

   public function form_update_status() {
      $id = $this->input->post('project_code', TRUE);
      $data['project_status'] = $this->bm->get('tb_project', 'project_id, ID_pm, ID_company, project_code_ID, project_progress, project_status', ['project_code_ID' => $id])->row();
      $this->load->view('pm/proyek/daftar/form/update_status', $data);
   }

   public function tampil_form_edit_proyek() {
      $post = $this->input->post(NULL, TRUE);
      $data['project'] = $this->bm->get('tb_project', '*', [
         'project_code_ID' => $post['project_code_ID'],
         'ID_pm'           => user_login()->user_id
      ])->row();
      $this->load->view('pm/proyek/detail/form_edit_proyek', $data);
   }

   public function tampil_form_edit_status_proyek() {
      $this->load->view('pm/proyek/detail/form_edit_status_proyek');
   }

      /**
    *
    * Download method
    * Mendownload laporan proyek yang sudah Selesai pengerjaannya
    * 
    */

   public function download_laporan() {
      $query = '';
      $bulan = '';
      $post = $this->input->post(NULL, TRUE);
      $ym_awal = $post['tahun_proyek'].'-'.$post['bulan_awal'];
      $ym_akhir = $post['tahun_proyek'].'-'.$post['bulan_akhir'];

      if ($post['bulan_awal'] == '' && $post['bulan_akhir'] == '') {
         $bulan = '';
         $query = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id);
      } else if ($post['bulan_awal'] == '' && $post['bulan_akhir'] != '') {
         $bulan = '';
         $query = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] == '') {
         $bulan = '';
         $query = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] != ''){
         $ym_awal = $post['tahun_proyek'].'-'.$post['bulan_awal'];
         $ym_akhir = $post['tahun_proyek'].'-'.$post['bulan_akhir'];
         $bulan = getMonthID($post['bulan_awal']).' s/d '.getMonthID($post['bulan_akhir']).' '.$post['tahun_proyek'];
         $query = $this->ppm->get_riwayat_filter($ym_awal, $ym_akhir, user_company()->company_id, user_login()->user_id);
      }

      if ($query->num_rows() > 0) {
         // Print PDF
         $data['month'] = $bulan;
         $data['total_count'] = $query->num_rows();
         $data['company'] = user_company()->comp_name;
         $data['logo'] = user_company()->comp_logo;
         $data['title'] = 'PT. Arya Bakti Saluyu';

         $rows = [];
         foreach($query->result() as $qr) {
            $deadline = '';

            if ($qr->project_deadline > $qr->project_current_deadline) {
               $deadline = 'Lebih Awal';
            } else if ($qr->project_deadline < $qr->project_current_deadline) {
               $deadline = 'Terlambat';
            } else if ($qr->project_deadline == $qr->project_current_deadline) {
               $deadline = 'Tepat Waktu';
            }
            $rows[] = [
               'proID'         => $qr->projectID,
               'thumbnail'     => $qr->project_thumbnail,
               'project_name'  => $qr->project_name,
               'pm'            => $qr->user_id == null ? ' - ' : $qr->user_fullname,
               'address'       => $qr->project_address,
               'deadline'      => dateTimeIDN($qr->project_deadline),
               'curr_deadline' => dateTimeIDN($qr->project_current_deadline),
               'keterangan'    => $deadline
            ];
         }
         $data['query'] = $rows;
         $rand_id = $this->mylibs->_randomID();
         $filename = 'LAPPROJPM-'.date('Ymdhis', time()).$rand_id;
         $this->cipdf->print('laporan_proyek', $data, $filename, 'A4', 'landscape');
      } else {
         echo "<script>
            alert('Oops! Data informasi yang ingin anda download tidak tersedia.');
            window.location = `".site_url('pm/riwayat')."`;
         </script>";
      }
   }
   // ==================================================================

   public function tinjau_proyek() {
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

   public function revisi_proyek() {
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