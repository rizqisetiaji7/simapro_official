<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_project extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = [
            'app_name'  => APP_NAME,
            'author'    => APP_AUTHOR,
            'title'     => 'Tes API',
            'desc'      => APP_NAME . ' - ' .'Rest API Simapro',
            'page'      => 'login',
            'footer_copyright'   => '<p class="text-muted text-center mt-4" style="font-size: 14px">&copy; Copyright '.date('Y', now('Asia/Jakarta')).' | Created by '.APP_AUTHOR.'.</p>'
        ];
        $this->theme->view('templates/auth_template', 'tes_api', $data);
    }
}