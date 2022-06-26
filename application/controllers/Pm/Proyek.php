<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
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

   protected function detail_proyek($comp_id, $project_code, $pm_id) {
      return $this->ppm->get_projectpm_detail($comp_id, $project_code, $pm_id)->row();
   }

   public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(PM) Daftar proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $this->tampil_proyek(20),
         'page'      => 'proyek'
      ];
      $this->theme->view('templates/main', 'pm/proyek/daftar/index', $data);
   }

   public function detail($comp_id, $project_code) {
      $project = $this->detail_proyek($comp_id, $project_code, user_login()->user_id);
      $subproject = $this->tampil_subproyek($project->project_id);
      $docs  = $this->ppm->get_documentation($project->project_id, NULL);
      
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(PM) Proyek Detail',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_detail',
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
      $post = $this->input->post(NULL, TRUE);
      $data['project'] = $this->bm->get('tb_project', '*', [
         'project_code_ID' => $post['project_code_ID'],
         'ID_pm'           => user_login()->user_id
      ])->row();
      $this->load->view('pm/proyek/detail/form_edit_proyek', $data);
   }

   function tampil_form_edit_status_proyek() {
      // $post = $this->input->post(NULL, TRUE);
      $this->load->view('pm/proyek/detail/form_edit_status_proyek');
   }

   function tampil_foto() {
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['subproject_id'] == '' ? NULL : $post['subproject_id'];
      $data['proj_name'] = $post['proj_name'];
      $data['project_status'] = $post['project_status'];
      $data['docs'] = $this->ppm->get_documentation($project_id, $subproject_id);
      $this->load->view('pm/proyek/detail/foto_dokumentasi', $data);
   }

   function tampil_form_tambah_subproyek() {
      $data['project_id'] = $this->input->post('project_id', TRUE);
      $data['priority'] = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('pm/proyek/detail/subproyek/modal_add_form', $data);
   }

   function tampil_form_edit_subproyek() {
      $project_id = $this->input->post('project_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['data_priority']    = $this->bm->get('tb_priority', '*')->result();
      $data['subproject'] = $this->bm->get('tb_subproject', '*', ['subproject_id' => $subproject_id, 'ID_project' => $project_id])->row();
      $this->load->view('pm/proyek/detail/subproyek/modal_edit_form', $data);
   }

   function form_tambah_subelemen_proyek() {
      $data['subproject_id']  = $this->input->post('subproject_id', TRUE);
      $data['project_id']     = $this->input->post('project_id', TRUE);
      $data['priority']       = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('pm/proyek/detail/subelemen/modalsubelemen_add_form', $data);
   }

   function form_edit_subelemen_proyek() {
      $subelemen_id = $this->input->post('task_id', TRUE);
      $subproject_id = $this->input->post('subproject_id', TRUE);
      $data['project_id']     = $this->input->post('project_id', TRUE);
      $data['subelemen'] = $this->bm->get('tb_project_task', '*', [
         'project_task_id' => $subelemen_id,
         'ID_subproject' => $subproject_id
      ])->row();
      $data['priority'] = $this->bm->get('tb_priority', '*')->result();
      $this->load->view('pm/proyek/detail/subelemen/modalsubelemen_edit_form', $data);
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
         $bulan = $this->_getMonthID($post['bulan_awal']).' s/d '.$this->_getMonthID($post['bulan_akhir']).' '.$post['tahun_proyek'];
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
}