<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_direktur();
      $this->load->model('project_model');
   }

   public function index() {
      $projects = $this->project_model->get_all_user_project(user_login()->ID_company, 10)->result();
      $data = [
         'app_name'     => APP_NAME,
         'author'       => APP_AUTHOR,
         'title'        => '(Direktur) Dashboard',
         'desc'         => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'     => $projects,
         'finished'     => countProjectFinish(user_company()->company_id),
         'on_progress'  => countProjectOnProgress(user_company()->company_id),
         'archived'     => countProjectArchive(user_company()->company_id),
         'page'         => 'direktur'
      ];
      $this->theme->view('templates/main', 'direktur/dashboard', $data);
   }
}