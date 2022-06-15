<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
   public function __construct() {
      parent::__construct();
      is_not_login();
      is_not_pm();
   }

   public function index() {
      $comp_id = user_company()->company_id;
      $pm_id = user_company()->user_id;
      $projects = $this->ppm->get_pm_projects($comp_id, $pm_id, 10)->result();

      $data = [
         'app_name'  => APP_NAME,
         'author'    => APP_AUTHOR,
         'title'     => 'Dashboard PM',
         'desc'      => APP_NAME . ' - ' . APP_DESC . ' ' . COMPANY,
         'projects'  => $projects,
         'page'      => 'proyek_manajer'
      ];
      $this->theme->view('templates/main', 'pm/dashboard', $data);
   }
}