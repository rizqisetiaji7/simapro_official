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
         'allowed_types' => 'jpg|jpeg|png',
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

   protected function _tampil_proyek($limit=1) {
      return $this->project_model->get_all_user_project(user_company()->company_id, $limit)->result();
   }

   protected function _data_detail_proyek($company_id, $project_code) {
      return $this->project_model->get_project_detail($company_id, $project_code)->row();
   }

   protected function _tampil_subproyek($project_id) {
      return $this->project_model->get_subproject($project_id)->result_array();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(Direktur) Daftar Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $this->_tampil_proyek(25),
         'page'      => 'daftar_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/daftar/index', $data);
   }

   // Detail Proyek
   public function detail($company_id, $project_code) {
      $project = $this->_data_detail_proyek($company_id, $project_code);
      $subproject = $this->_tampil_subproyek($project->project_id);
      $docs = $this->project_model->get_documentation($project->project_id, NULL);

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => '(Direktur) Detail Proyek',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'         => 'detail_proyek',
         'docs'         => $docs
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
         'user_id'               => $project->user_id,
         'user_role'             => $project->user_role,
         'user_fullname'         => $project->user_fullname,
         'user_profile'          => $project->user_profile,
         'comp_name'             => $project->comp_name,
         'subproject'            => $subproject
      ];

      $this->theme->view('templates/main', 'direktur/proyek/detail/index', $data);
   }

   public function form_tambah() {
      $data['project_code_ID'] = urlencode(base64_encode(getIDCode('PROY', user_company()->comp_prefix)));
      $data['project_man'] = $this->bm->get('tb_users', 'user_id, user_fullname', ['ID_company' => user_company()->company_id, 'user_role' => 'pm'])->result();
      $this->load->view('direktur/proyek/daftar/form_tambah', $data);
   }

   public function form_edit() {
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

      $this->load->view('direktur/proyek/detail/form_edit_proyek', $data);
   }

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
            'project_current_deadline' => NULL,
            'project_deadline_month'   => NULL,
            'project_status'        => 'none',
            'project_progress'      => 0,
            'project_archive'       => '0',
            'created'               => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];
         
         $this->upload->initialize($this->_file_upload_config('./uploads/thumbnail'));
         // Upload File Thumbnail Image
         if (@$_FILES['profile_image']['name'] != NULL) {
            if ($this->upload->do_upload('profile_image')) {
               $thumbnail = $this->upload->data();
               resize_image('./uploads/thumbnail/'.$thumbnail['file_name']);
               $data['project_thumbnail'] = $thumbnail['file_name'];
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

   function edit() {
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

   function form_edit_status() {
      $id = $this->input->post('project_code', TRUE);
      $project_status = $this->bm->get($this->tb_project, 'project_id, ID_pm, ID_company, project_code_ID, project_progress, project_status', ['project_code_ID' => $id])->row();
      $docs = $this->project_model->get_documentation_project($project_status->project_id);

      $data = [
         'project_status'  => $project_status,
         'docs'            => $docs
      ];
      $this->load->view('direktur/proyek/daftar/form_edit_status', $data);
   }

   function edit_status() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->bm->update($this->tb_project, [
         'project_status' => $post['project_status']
      ],[
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

   /**
    *
    * Download method
    * Mendownload laporan proyek yang sudah Selesai pengerjaannya
    * 
    */
   function download_laporan() {
      $query = '';
      $bulan = '';
      $post = $this->input->post(NULL, TRUE);
      $ym_awal = $post['tahun_proyek'].'-'.$post['bulan_awal'];
      $ym_akhir = $post['tahun_proyek'].'-'.$post['bulan_akhir'];

      if ($post['bulan_awal'] == '' && $post['bulan_akhir'] == '') {
         $bulan = '';
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] == '' && $post['bulan_akhir'] != '') {
         $bulan = '';
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] == '') {
         $bulan = '';
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] != ''){
         $ym_awal = $post['tahun_proyek'].'-'.$post['bulan_awal'];
         $ym_akhir = $post['tahun_proyek'].'-'.$post['bulan_akhir'];
         $bulan = getMonthID($post['bulan_awal']).' s/d '.getMonthID($post['bulan_akhir']).' '.$post['tahun_proyek'];
         $query = $this->project_model->get_riwayat_filter($ym_awal, $ym_akhir, user_company()->company_id);
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
         $filename = 'LAPPROJ-'.date('Ymdhis', time()).$rand_id;
         $this->cipdf->print('laporan_proyek', $data, $filename, 'A4', 'landscape');
      } else {
         echo "<script>
            alert('Oops! Data informasi yang ingin anda download tidak tersedia.');
            window.location = `".site_url('direktur/proyek/riwayat')."`;
         </script>";
      }
   }
   // ==================================================================

   function revisi_proyek() {
      $message = [];
      $project_id = $this->input->post('project_id', TRUE);
      $this->bm->update($this->tb_project, [
         'project_status'  => 'revision',
         'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ], ['project_id'   => $project_id]);

      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => 'Proyek sedang direvisi kembali.',
            'redirect'  => site_url('direktur/riwayat')
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! maaf terjadi kesalahan, silahkan periksa koneksi/jaringan anda, lalu coba lagi.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function proyek_selesai() {
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
            'message'   => 'Proyek yang telah anda kerjakan telah selesai.',
            'redirect'  => site_url('direktur/proyek')
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