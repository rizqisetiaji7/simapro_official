<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller {
   private $table = 'tb_company';
   private $placeholder = 'default-placeholder320x320.png';

   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('company_model');
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
         ],
         [
            'field'  => 'comp_since',
            'label'  => 'Tanggal',
            'rules'  => 'trim|required',
            'errors' => [
               'required' => '{field} wajib diisi.'
            ]
         ]
      ];

      return $config;
   }

   public function index() {
      $getMainComp = $this->company_model->get_main_company(user_login()->user_id)->row();
      $subcompany = $this->company_model->get_subcompany($getMainComp->company_id)->result();

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => 'Daftar perusahaan',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'main_comp'    => $getMainComp,
         'subcompany'   => $subcompany,
         'page'         => 'perusahaan'
      ];
      $this->theme->view('templates/main', 'direktur/perusahaan/index', $data);
   }

   public function show_form() {
      $type = $this->input->post('modal_type');

      if ($type == 'add') {
         $this->load->view('direktur/perusahaan/form_add');
      } else if ($type == 'edit') {
         $company_id = $this->input->post('company_id');
         $parent_id = $this->input->post('parent_id');
         $data['company'] = $this->bm->get($this->table, '*', ['company_id' => $company_id, 'comp_parent_id' => $parent_id])->row();

         $this->load->view('direktur/perusahaan/form_edit', $data);
      }
   }

   public function tambah() {
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
               ['field' => 'comp_type', 'err_message' => form_error('comp_type', '<span>','</span>')],
               ['field' => 'comp_since', 'err_message' => form_error('comp_since', '<span>','</span>')]
            ]
         ];
      } else {
         $config = [
            'upload_path'   => './uploads/company',
            'allowed_types' => 'jpg|jpeg|png|svg',
            'max_size'      => 4096, // 4MB
            'encrypt_name'  => TRUE,
            'remove_spaces' => TRUE
         ];

         // Initialize Config upload
        $this->upload->initialize($config);

         if (@$_FILES['comp_logo']['name'] != null) {
            if ($this->upload->do_upload('comp_logo')) {
               $post['logo'] = $this->upload->data('file_name');
               $this->company_model->insert_comp($post);

               if ($this->db->affected_rows() > 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data anak perusahaan telah berhasil disimpan.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Maaf data anak perusahaan gagal disimpan.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data anak perusahaan gagal disimpan.'
               ];
            }
         } else {
            $post['logo'] = $this->placeholder;
            $this->company_model->insert_comp($post);
            if ($this->db->affected_rows() > 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data anak perusahaan telah berhasil disimpan.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf data anak perusahaan gagal disimpan.'
               ];
            }
         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
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
               ['field' => 'comp_type', 'err_message' => form_error('comp_type', '<span>','</span>')],
               ['field' => 'comp_since', 'err_message' => form_error('comp_since', '<span>','</span>')]
            ]
         ];
      } else {
         $datacomp = $this->bm->get($this->table, '*', ['company_id' => $post['company_id'], 'comp_parent_id' => $post['comp_parent_id']])->row();

         $config = [
            'upload_path'   => './uploads/company',
            'allowed_types' => 'jpg|jpeg|png|svg',
            'max_size'      => 4096, // 4MB
            'encrypt_name'  => TRUE,
            'remove_spaces' => TRUE
         ];

         $this->upload->initialize($config);
         if (@$_FILES['comp_logo']['name'] != NULL) {
            if ($this->upload->do_upload('comp_logo')) {
               if ($datacomp->comp_logo != $this->placeholder) {
                  unlink('uploads/company/'.base64_decode($post['old']));
               }
               
               $post['comp_logo'] = $this->upload->data('file_name');
               // Update Query
               $this->company_model->update_company($post);
               if ($this->db->affected_rows() >= 0) {
                  $message = [
                     'status'    => 'success',
                     'message'   => 'Data anak perusahaan telah berhasil diperbarui.'
                  ];
               } else {
                  $message = [
                     'status'    => 'failed',
                     'message'   => 'Oops! Data anak perusahaan gagal diubah.'
                  ];
               }
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Logo gagal diubah. Silahkan periksa ukuran (max 4MB) dan tipe file (JPG, JPEG, PNG)'
               ];
            }
         } else {
            $post['comp_logo'] = $datacomp->comp_logo == $this->placeholder ? $datacomp->comp_logo : base64_decode($post['old']);
            // Update Query
            $this->company_model->update_company($post);
            if ($this->db->affected_rows() >= 0) {
               $message = [
                  'status'    => 'success',
                  'message'   => 'Data anak perusahaan telah berhasil diperbarui.'
               ];
            } else {
               $message = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Data anak perusahaan gagal diubah.'
               ];
            }
         }
      }

      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   public function detail_perusahaan($id_company, $comp_parent_id, $type_company) {
      $typecomp = base64_decode(urldecode($type_company));
      $user_role = $typecomp == 'subcompany' ? 'admin' : 'super_admin';
      $director = $this->company_model->get_director($id_company, $user_role);

      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => 'Detail perusahaan',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'company'      => $this->bm->get($this->table, '*', ['company_id' => $id_company, 'comp_parent_id' => $comp_parent_id])->row(),
         'director'     => $director,
         'page'         => 'detail_perusahaan'
      ];

      $this->theme->view('templates/main', 'direktur/perusahaan/detail/index', $data);
   }
}