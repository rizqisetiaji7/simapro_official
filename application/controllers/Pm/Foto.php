<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Foto extends CI_Controller {
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

   // UPLOAD DOKUMENTASI
   function upload_foto() {
      $data = [];
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $countPhoto = count($_FILES['project_photo']['name']);
      $pathUpload = '';
      if ($post['type_pro'] == 'proyek') {
         $pathUpload = 'project_doc';
      } else if ($post['type_pro'] == 'subproyek'){
         $pathUpload = 'subproject_doc';
      }

      for ($i = 0; $i < $countPhoto; $i++) {
         if (isset($_FILES['project_photo']['name'][$i])) {
            $_FILES['photo']['name']      = $_FILES['project_photo']['name'][$i];
            $_FILES['photo']['type']      = $_FILES['project_photo']['type'][$i];
            $_FILES['photo']['tmp_name']  = $_FILES['project_photo']['tmp_name'][$i];
            $_FILES['photo']['error']     = $_FILES['project_photo']['error'][$i];
            $_FILES['photo']['size']      = $_FILES['project_photo']['size'][$i];
            
            $this->upload->initialize($this->_file_upload_config('./uploads/'.$pathUpload));
            if (!$this->upload->do_upload('photo')) {
               // Error
               $message[$i] = [
                  'status'    => 'failed',
                  'message'   => 'Oops! Maaf gambar gagal diupload. Silahkan cek kembali koneksi atau file yang akan diupload!',
                  'errors'    => ['error' => $this->upload->display_errors()]
               ];
            } else {
               // Get upload data
               $photo = $this->upload->data();
               // Compress File Size
               resize_image('./uploads/'.$pathUpload.'/'.$photo['file_name']);

               // Store the data into array variable
               $data[] = [
                  'ID_project'      => $post['proj_id'],
                  'ID_subproject'   => $post['subproj_id'] == '' ? NULL : $post['subproj_id'],
                  'photo_url'       => $pathUpload.'/'.$photo['file_name'],
                  'created'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
               ];
            }
         }
      }
      // Save Photo to database
      $this->bm->save('tb_photo', $data, TRUE);
      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'message'   => $countPhoto.' Gambar telah berhasil diupload'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'message'   => 'Oops! Maaf gambar gagal diupload. Silahkan cek kembali koneksi atau file yang akan diupload!'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function tampil_foto() {
      $post = $this->input->post(NULL, TRUE);
      $project_id = $post['project_id'];
      $subproject_id = $post['subproject_id'] == 0 ? NULL : $post['subproject_id'];
      $data['proj_name'] = $post['proj_name'];
      $data['project_status'] = $post['project_status'];
      $data['proj_type'] = $post['proj_type'];
      $data['docs'] = $this->ppm->get_documentation($project_id, $subproject_id);
      $this->load->view('pm/proyek/detail/foto_dokumentasi', $data);
   }

   function hapus() {
      $message = [];
      $post = $this->input->post(NULL, TRUE);
      $this->bm->delete('tb_photo', [
         'photo_id'        => $post['photo_id'],
         'ID_project'      => $post['project_id'],
         'ID_subproject'   => $post['subproject_id'] == 0 ? NULL : $post['subproject_id']
      ]);
      unlink('./uploads/'.$post['photo_url']);
      if ($this->db->affected_rows() > 0) {
         $message = [
            'status'    => 'success',
            'proj_type' => $post['proj_type'],
            'message'   => 'Gambar telah telah terhapus.'
         ];
      } else {
         $message = [
            'status'    => 'failed',
            'proj_type' => $post['proj_type'],
            'message'   => 'Oops! Maaf gambar gagal dihapus.'
         ];
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }
}