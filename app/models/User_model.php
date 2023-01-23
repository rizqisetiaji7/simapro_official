<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	private function _getQuery($table,$search) {
		$this->db->from($table);
		if (isset($_POST['search']['value'])) {
			$this->db->like($search[0], $_POST['search']['value']);
			if (count($search) > 1) {
				for ($i = 0; $i < count($search); ++$i) {
					$this->db->or_like($search[$i], $_POST['search']['value']);
				}
			}
		}
	}

	private function _order($data) {
		if (isset($_POST['order'])) {
			$sCol = $_POST['order'][0]['column'];
			$sDir = $_POST['order'][0]['dir'];
			$this->db->order_by($data['columns'][$sCol], $sDir);
		} else {
			$this->db->order_by($data['columns'][0], $data['sort_order']);
		}
		return $this;
	}

	private function _limit() {
		return ($_POST['length'] != -1) ? $this->db->limit($_POST['length'], $_POST['start']) : false;
	}

	public function getDataTable($config) {
		$this->_getQuery($config['table'], $config['allowed_search']);
		$this->_order($config);
		$this->_limit();
		return $this->db->get()->result();
	}

	public function countFiltered($config) {
		$this->_getQuery($config['table'], $config['allowed_search']);
		return $this->db->get()->num_rows();
	}

	public function countAll($config) {
		$this->db->from($config['table']);
		return $this->db->count_all_results();
	}
}