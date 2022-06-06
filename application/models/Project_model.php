<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
	private $tb_project = 'tb_project';
	private $tb_company = 'tb_company';
	private $tb_users = 'tb_users';

	public function get_all_user_project($comp_id) {
		$columns = 'tb_project.project_id, tb_project.ID_pm, tb_project.ID_company as project_compID, tb_project.project_code_ID as projectID, tb_project.project_name, tb_project.project_thumbnail, tb_project.project_address, tb_project.project_deadline, tb_project.project_status, tb_project.project_progress, tb_company.company_id, tb_company.comp_parent_id as comp_parent, tb_company.comp_code, tb_company.comp_prefix, tb_company.comp_name, tb_users.user_id, tb_users.ID_company as user_ID_company, tb_users.user_role, tb_users.user_profile, tb_users.user_fullname';

		$this->db->select($columns);
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_company, $this->tb_company.'.company_id='.$this->tb_project.'.ID_company', 'left');
		$this->db->join($this->tb_users, $this->tb_users.'.user_id='.$this->tb_project.'.ID_pm', 'left');
		$this->db->where('tb_project.ID_company', $comp_id);
		$this->db->where('tb_project.project_status', NULL);
		$this->db->or_where('tb_project.project_status', 'pending');
		$this->db->or_where('tb_project.project_status', 'review');
		$this->db->or_where('tb_project.project_status', 'on_progress');
		$this->db->or_where('tb_project.project_status', 'revision');
		return $this->db->get();
	}
}