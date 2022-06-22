<?php 

class Riwayat extends CI_Controller {
	public function __construct() {
		parent::__construct();
      is_not_login();
      is_not_pm();
	}

	public function index() {
      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => '(PM) Riwayat Proyek',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'page'      => 'proyek_riwayat'
      ];
      $this->theme->view('templates/main', 'pm/proyek/riwayat/index', $data);
   }

	function tampil_riwayat_proyek() {
      $data['projects'] = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id, 10);
      $this->load->view('pm/proyek/riwayat/list_proyek', $data);
   }

   function filter_data() {
      $post = $this->input->post(NULL, TRUE);
      $query = '';
      if ($post['bulan_awal'] == '' && $post['bulan_akhir'] == '') {
         $query = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id);
      } else if ($post['bulan_awal'] == '' && $post['bulan_akhir'] != '') {
         $query = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] == '') {
         $query = $this->ppm->get_finished_project(user_company()->company_id, user_login()->user_id);
      } else if ($post['bulan_awal'] != '' && $post['bulan_akhir'] != ''){
         $ym_awal = $post['tahun'].'-'.$post['bulan_awal'];
         $ym_akhir = $post['tahun'].'-'.$post['bulan_akhir'];
         $query = $this->ppm->get_riwayat_filter($ym_awal, $ym_akhir, user_company()->company_id, user_login()->user_id);
      }
      $data['filtered'] = $query;
      $this->load->view('pm/proyek/riwayat/filtered_data', $data);
   }
}