<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {
   public function index() {
      $data['author']         = APP_NAME;
      $data['title']          = '404 Page Not Found';
      $data['heading']        = 'Oops! Page not found!';
      $data['message']        = 'The page you requested was not found.';
      $data['redirect_url']   = site_url();
      $this->load->view('404', $data);
   }
}