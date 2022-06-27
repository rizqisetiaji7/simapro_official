<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subproyek extends CI_Controller {
   private $tb_subproject = 'tb_subproject';

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

   public function form_tambah_subproyek() {
      $data['project_id']  = $this->input->post('project_id');
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

   }

   function edit() {
      
   }

   function hapus() {
      
   }
}