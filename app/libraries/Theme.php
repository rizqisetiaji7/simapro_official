<?php 

class Theme {
	public $view_data = [];
	// public $template_name = '';

	/**
	 * Inisialisasi nama template yang akan digunakan berdasarkan direktori dan file view
	 * @param $name
	 * @param $value
	 */

	function _set($name, $value) {
		$this->view_data[$name] = $value;
	}

	/**
	 * Menampilkan view dengan template yang di set, beserta dapat mengirimkan data
	 * @param $template_path string
	 * @param $view string
	 * @param $data array
	 * @param $return boolean
	 * @return view
	 */

	public function view($template_path, $view, $data = [], $return = FALSE) {
		$this->CI =& get_instance();
		$this->_set('page_content', $this->CI->load->view($view, $data, TRUE));
		return $this->CI->load->view($template_path, $this->view_data, $return);
	}
}