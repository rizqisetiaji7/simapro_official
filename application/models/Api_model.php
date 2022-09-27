<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
	private $table = 'tb_project';
	
	private function columns() {
		return "
			tb_project.project_id, 
			tb_project.project_code_ID as code_ID, 
			tb_project.project_name, 
			tb_project.project_thumbnail, 
			tb_project.project_address, 
			tb_project.project_description, 
			tb_project.project_start, 
			tb_project.project_deadline, 
			tb_project.project_current_deadline,  
			tb_project.project_status, 
			tb_project.project_progress, 
			tb_company.company_id,  
			tb_company.comp_code, 
			tb_company.comp_name, 
			tb_users.user_id, 
			tb_users.user_unique_id, 
			tb_users.ID_company as user_ID_company, 
			tb_users.user_profile, 
			tb_users.user_fullname
		";
	}

	public function get_projects($project_id=NULL, $status='finish', $limit=NULL) {
		$this->db->select($this->columns());
		$this->db->from($this->table);
		$this->db->join('tb_company', 'tb_company.company_id=tb_project.ID_company', 'left');
		$this->db->join('tb_users', 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.project_status' 	=> $status,
			'tb_project.project_archive !='	=> 1
		]);

		if ($project_id !== NULL) {
			$this->db->where(['tb_project.project_id' => $project_id]);
		}

		if (!is_null($limit)) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('project_id DESC');
		return $this->db->get()->result_array();
	}
}