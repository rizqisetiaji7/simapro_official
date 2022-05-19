<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mytheme extends CI_Controller {
	private $table = 'tb_users';

   public function __construct() {
      parent::__construct();
      is_not_login();
   }

   function switch_theme() {
      $id = $this->input->post('userid', true);
      $theme = $this->input->post('theme', true);
      $this->bm->update($this->table, ['theme_mode' => $theme], ['user_id' => $id]);
      $message = $this->db->affected_rows() >= 0 ? ['status' => 'OK'] : ['status' => 'ERROR'];
      $this->output->set_content_type('application/json')->set_output(json_encode($message));
   }

   function get_theme() {
      $theme_mode = $this->mylibs->user_login()->theme_mode;
      $data = [
         'theme_mode'      => $theme_mode,
         'theme_style' => $theme_mode == 1 ? base_url(DARK_STYLE) : base_url(DEFAULT_STYLE)
      ];
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   } 
}