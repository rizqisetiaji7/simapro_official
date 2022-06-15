<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Projectpm_model extends CI_Model {
	private $tb_project = 'tb_project';

	private function _columns() {
		return 'tb_project.project_id, tb_project.ID_pm, tb_project.ID_company as project_compID, tb_project.project_code_ID as projectID, tb_project.project_name, tb_project.project_thumbnail, tb_project.project_address, tb_project.project_description, tb_project.project_start, tb_project.project_deadline, tb_project.project_current_deadline, tb_project.project_deadline_month, tb_project.project_status, tb_project.project_progress, tb_project.project_archive, tb_company.company_id, tb_company.comp_parent_id as comp_parent, tb_company.comp_code, tb_company.comp_prefix, tb_company.comp_name, tb_users.user_id, tb_users.ID_company as user_ID_company, tb_users.user_role, tb_users.user_profile, tb_users.user_fullname';
	}

	public function get_pm_projects($comp_id, $pm_id, $limit = FALSE) {
		$this->db->select($this->_columns());
		$this->db->from($this->tb_project);
		$this->db->join('tb_company', 'tb_company.company_id=tb_project.ID_company', 'left');
		$this->db->join('tb_users', 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 			=> $comp_id,
			'tb_project.project_archive !='	=> 1,
			'tb_project.project_status !='	=> 'finish',
			'tb_project.ID_pm'					=> $pm_id
		]);
		if ($limit != FALSE) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('project_id DESC');
		return $this->db->get();
	}

	public function get_pm_project_archive($comp_id, $pm_id, $limit = FALSE) {
		$this->db->select($this->_columns());
		$this->db->from('tb_project');
		$this->db->join('tb_company', 'tb_company.company_id=tb_project.ID_company', 'left');
		$this->db->join('tb_users', 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 		=> $comp_id,
			'tb_project.project_status'	=> 'pending',
			'tb_project.project_archive'	=> 1,
			'tb_project.ID_pm'				=> $pm_id
		]);
		if ($limit != FALSE) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('project_id DESC');
		return $this->db->get();
	}
}