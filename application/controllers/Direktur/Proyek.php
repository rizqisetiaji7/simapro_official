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
      $project_status = $this->bm->get($this->tb_project, 'project_id, ID_pm, ID_company, project_code_ID, project_progress, project_status', ['project_code_ID' => $id])->row();
      $docs = $this->project_model->get_documentation_project($project_status->project_id);

      $data = [
         'project_status'  => $project_status,
         'docs'            => $docs
      ];

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
            'project_status'        => 'on_progress',
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
      $this->theme->view('templates/main', 'direktur/proyek/riwayat_proyek/index', $data);
   }

   function show_riwayat_proyek() {
      $data['projects'] = $this->project_model->get_finished_project(user_company()->company_id, 10);
      $this->load->view('direktur/proyek/riwayat_proyek/list_proyek', $data);
   }

   function filterData() {
      $post = $this->input->post(NULL, TRUE);
      $query = '';
      if ($post['bulan_awal'] == '' && $post['bulan_akhir'] == '') {
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] == '' && $post['bulan_akhir'] != '') {
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] == '') {
         $query = $this->project_model->get_finished_project(user_company()->company_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] != ''){
         $ym_awal = $post['tahun'].'-'.$post['bulan_awal'];
         $ym_akhir = $post['tahun'].'-'.$post['bulan_akhir'];
         $query = $this->project_model->get_riwayat_filter($ym_awal, $ym_akhir, user_company()->company_id);
      }
      $data['filtered'] = $query;
      $this->load->view('direktur/proyek/riwayat_proyek/filtered_data', $data);
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
         $bulan = $this->_getMonthID($post['bulan_awal']).' s/d '.$this->_getMonthID($post['bulan_akhir']).' '.$post['tahun_proyek'];
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

   protected function _getMonthID($month_num) {
      $months = [
         '01'  => 'Januari',
         '02'  => 'Februari',
         '03'  => 'Maret',
         '04'  => 'April',
         '05'  => 'Mei',
         '06'  => 'Juni',
         '07'  => 'Juli',
         '08'  => 'Agustus',
         '09'  => 'September',
         '10'  => 'Oktober',
         '11'  => 'November',
         '12'  => 'Desember'
      ];
      $m = $months[$month_num];
      return $m;
   }

   // ==================================================================

   function arsip_proyek() {
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

   function detail_proyek($company_id, $project_code_ID) {
      $project = $this->project_model->get_project_detail($company_id, $project_code_ID)->row();
      $subproject = $this->project_model->get_subproject([
         'ID_project' => $project->project_id
      ]);
      $docs = $this->project_model->get_documentation_project($project->project_id);

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => 'Detail Proyek',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'project'      => $project,
         'subproject'   => $subproject,
         'docs'         => $docs,
         'page'         => 'detail_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/detail_proyek/index', $data);
   }

   function detail_arsip($company_id, $project_code_ID) {
      // Get Archived Project
      $project = $this->project_model->get_project_detail($company_id, $project_code_ID, TRUE)->row();
      $subproject = $this->project_model->get_subproject([
         'ID_project' => $project->project_id
      ]);

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => 'Detail Arsip Proyek',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'project'      => $project,
         'subproject'   => $subproject,
         'page'         => 'detail_arsip_proyek'
      ];
      $this->theme->view('templates/main', 'direktur/proyek/arsip/arsip_detail', $data);
   }

   function detail_proyek_arsip() {
      $project_id = $this->input->post('project_id', TRUE);
      $project_code_ID = $this->input->post('project_code', TRUE);
      $data['docs'] = $this->project_model->get_documentation_project($project_id);
      $data['project'] = $this->project_model->detail_archive($project_id, $project_code_ID, TRUE)->row();
      $this->load->view('direktur/proyek/arsip/detail_proyek_arsip', $data);
   }

   function form_edit_proyek() {
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

   function edit_detail_proyek() {
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