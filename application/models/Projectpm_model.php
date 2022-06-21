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

	public function get_projectpm_detail($company_id, $proj_ID, $pm_id, $archived = FALSE) {
		$this->db->select($this->_columns());
		$this->db->from('tb_project');
		$this->db->join('tb_company', 'tb_company.company_id=tb_project.ID_company', 'left');
		$this->db->join('tb_users', 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 		=> $company_id,
			'tb_project.project_code_ID'	=> $proj_ID,
			'tb_project.ID_pm'				=> $pm_id
		]);
		if ($archived != FALSE) {
			$this->db->where('tb_project.project_archive', 1);
		}
		return $this->db->get();
	}

	public function get_subprojectpm($project_id) {
		$this->db->from('tb_subproject');
		$this->db->join('tb_priority', 'tb_subproject.ID_priority=tb_priority.priority_id');
		$this->db->where(['ID_project' => $project_id]);
		$this->db->order_by('subproject_id DESC');
		return $this->db->get();
	}

	public function detail_pmarchive($project_id, $project_code, $id_pm) {
		$this->db->from($this->tb_project);
		$this->db->join('tb_users', 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.project_id' 		=> $project_id,
			'tb_project.project_code_ID' 	=> $project_code,
			'tb_project.ID_pm'				=> $id_pm
		]);
		return $this->db->get();
	}

	public function get_documentation($project_id, $subproject_id=NULL) {
		$this->db->select('tb_photo.photo_id, tb_photo.ID_project as proj_ID, tb_photo.ID_subproject as subproj_ID, tb_photo.photo_url as url, tb_photo.created as photo_created, tb_project.project_id');
		$this->db->from('tb_photo');
		$this->db->join('tb_project', 'tb_photo.ID_project=tb_project.project_id', 'left');
		$this->db->where([
			'tb_photo.ID_project' => $project_id, 
			'tb_photo.ID_subproject' => $subproject_id
		]);
		$this->db->order_by('photo_id DESC');
		return $this->db->get();
	}

	public function countRows($table, $where) {
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}

	public function sumTotalProgress($table, $column, $as, $where) {
		$this->db->select("SUM(".$column.") as ". $as);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}
}