<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller {
   private $table_company = 'tb_company';
   private $placeholder = 'default-placeholder320x320.png';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      unset_chat_session();
      $this->load->model('company_model');
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
            'field'  => 'comp_name',
            'label'  => 'Nama anak perusahaan',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ],
         [
            'field'  => 'comp_email',
            'label'  => 'Email',
            'rules'  => 'trim|required|valid_email',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'valid_email'  => 'Format {field} tidak valid. Silahkan isi email dengan benar.',
            ]
         ],
         [
            'field'  => 'comp_phone',
            'label'  => 'Nomor telepon',
            'rules'  => 'trim|required|numeric|min_length[10]|max_length[15]',
            'errors' => [
               'required'     => '{field} wajib diisi.',
               'numeric'      => '{field} wajib angka.',
               'min_length'   => '{field} minimal 10 digit angka.',
               'max_length'   => '{field} maksimal 15 digit angka.'
            ]
         ],
         [
            'field'  => 'comp_type',
            'label'  => 'Tipe perusahaan',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ]
      ];
      return $config;
   }

   public function _tampil_data() {
      return $this->company_model->get_company(user_login()->user_id)->row();
   }

   public function index() {
      $data = [
         'app_name'        => APP_NAME,
         'author'          => APP_AUTHOR,
         'title'           => 'Perusahaan',
         'desc'            => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'main_comp'       => $this->_tampil_data(),
         'page'            => 'perusahaan'
      ];
      $this->theme->view('templates/main', 'direktur/perusahaan/index', $data);
   }
   
   public function edit() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->form_validation->set_rules($this->_rules());
      if ($this->form_validation->run() == FALSE) {
         $message = [
            'status' => 'validation_error',
            'message' => [
               ['field' => 'comp_name', 'err_message' => form_error('comp_name', '<span>','</span>')],
               ['field' => 'comp_email', 'err_message' => form_error('comp_email', '<span>','</span>')],
               ['field' => 'comp_phone', 'err_message' => form_error('comp_phone', '<span>','</span>')],
               ['field' => 'comp_type', 'err_message' => form_error('comp_type', '<span>','</span>')]
            ]
         ];
      } else {
         $comp_code = '';
         if ($post['comp_since'] == $post['old_comp_since']) {
            $comp_code = $post['comp_code'];
         } else {
            $since_code = explode('-', $post['comp_since']);
            $since_code = implode($since_code);
            $comp_code = getIDCode('COMP', $since_code);
         }
         $data = [
            'comp_code'    => $comp_code,
            'comp_name'    => $post['comp_name'],
            'comp_phone'   => $post['comp_phone'],
            'comp_email'   => $post['comp_email'],
            'comp_type'    => $post['comp_type'],
            'comp_since'   => $post['comp_since'],
            'comp_address' => $post['comp_address'],
            'comp_desc'    => $post['comp_desc'],
            'updated'      => date('Y-m-d H:i:s', now('Asia/Jakarta'))
         ];
         $this->bm->update($this->table_company, $data, ['company_id' => $post['company_id']]);

         if ($this->db->affected_rows() >= 0) {
            $message = [
               'status'    => 'success',
               'message'   => 'Data Perusahaan berhasil diupdate.'
            ];
         } else {
            $message = [
               'status'    => 'failed',
               'message'   => 'Oops! Data Perusahaan gagal diupdate.'
            ];
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function upload_form_logo() {
      $company_code = $this->input->post('company_code', TRUE);
      $data['company'] = $this->bm->get($this->table_company, '*', ['comp_code' => $company_code])->row();
      $this->load->view('direktur/profile/upload_logo_form', $data);
   }

   public function upload_logo_company() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);

      $this->upload->initialize($this->_file_upload_config('./uploads/company'));
      // Update Logo Company Process
      if (@$_FILES['logo_image']['name'] != NULL) {
         if ($this->upload->do_upload('logo_image')) {
            if ($post['old_logo'] != 'default-placeholder320x320.png') {
               unlink('./uploads/company/'.$post['old_logo']);
            }
            $photo = $this->upload->data();
            resize_image('./uploads/company/'.$photo['file_name']);
            $data = [
               'comp_logo' => $photo['file_name'],
               'updated'   => date('Y-m-d H:i:s', now('Asia/Jakarta'))
            ];

            $this->bm->update($this->table_company, $data, ['comp_code' => $post['comp_code']]);
            if ($this->db->affected_rows() >= 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Logo perusahaan telah berhasil dipebarui.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Logo perusahaan gagal dipebarui.'
               ];
            }
         }
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}