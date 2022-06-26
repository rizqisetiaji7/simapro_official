<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
	private $tb_project = 'tb_project';
	private $tb_subproject = 'tb_subproject';
	private $tb_project_task = 'tb_project_task';
	private $tb_company = 'tb_company';
	private $tb_users = 'tb_users';

	private function _columns1() {
		return $colummns = 'tb_project.project_id, tb_project.ID_pm, tb_project.ID_company as project_compID, tb_project.project_code_ID as projectID, tb_project.project_name, tb_project.project_thumbnail, tb_project.project_address, tb_project.project_description, tb_project.project_start, tb_project.project_deadline, tb_project.project_current_deadline, tb_project.project_deadline_month, tb_project.project_status, tb_project.project_progress, tb_project.project_archive, tb_company.company_id, tb_company.comp_parent_id as comp_parent, tb_company.comp_code, tb_company.comp_prefix, tb_company.comp_name, tb_users.user_id, tb_users.ID_company as user_ID_company, tb_users.user_role, tb_users.user_profile, tb_users.user_fullname';
	}

	public function get_all_user_project($comp_id, $limit=FALSE) {
		$this->db->select($this->_columns1());
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_company, $this->tb_company.'.company_id='.$this->tb_project.'.ID_company', 'left');
		$this->db->join($this->tb_users, $this->tb_users.'.user_id='.$this->tb_project.'.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 			=> $comp_id,
			'tb_project.project_archive !='	=> 1,
			'tb_project.project_status !='	=> 'finish'
		]);
		if ($limit != FALSE) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('project_id DESC');
		return $this->db->get();
	}

	public function get_finished_project($comp_id, $limit=FALSE) {
		$this->db->select($this->_columns1());
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_company, $this->tb_company.'.company_id='.$this->tb_project.'.ID_company', 'left');
		$this->db->join($this->tb_users, $this->tb_users.'.user_id='.$this->tb_project.'.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 		=> $comp_id,
			'tb_project.project_status'	=> 'finish'
		]);
		if ($limit != FALSE) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('project_id DESC');
		return $this->db->get();
	}

	public function get_project_detail($company_id, $proj_ID, $archived = FALSE) {
		$this->db->select($this->_columns1());
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_company, $this->tb_company.'.company_id='.$this->tb_project.'.ID_company', 'left');
		$this->db->join($this->tb_users, $this->tb_users.'.user_id='.$this->tb_project.'.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 		=> $company_id,
			'tb_project.project_code_ID'	=> $proj_ID
		]);
		if ($archived != FALSE) {
			$this->db->where('tb_project.project_archive', 1);
		}
		return $this->db->get();
	}

	public function detail_archive($project_id, $project_code, $limit=FALSE) {
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_users, 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.project_id' 		=> $project_id,
			'tb_project.project_code_ID' 	=> $project_code,
		]);
		if ($limit != FALSE) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('project_id DESC');
		return $this->db->get();
	}

	public function get_project_archive($comp_id) {
		$this->db->select($this->_columns1());
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_company, $this->tb_company.'.company_id='.$this->tb_project.'.ID_company', 'left');
		$this->db->join($this->tb_users, $this->tb_users.'.user_id='.$this->tb_project.'.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 			=> $comp_id,
			'tb_project.project_status'		=> 'pending',
			'tb_project.project_archive'		=> 1,
		]);
		return $this->db->get();
	}

	public function get_subproject($project_id, $subproject_id=NULL) {
		$this->db->from($this->tb_subproject);
		$this->db->join('tb_priority', 'tb_subproject.ID_priority=tb_priority.priority_id');
		$this->db->where(['ID_project' => $project_id]);
		if ($subproject_id != NULL) {
			$this->db->where(['subproject_id' => $subproject_id]);
		}
		$this->db->order_by('subproject_id DESC');
		return $this->db->get();
	}

	public function get_subelemen_project($subproject_id) {
		$this->db->from($this->$tb_project_task);
		$this->db->join('tb_priority', 'tb_project_task.ID_priority=tb_priority.priority_id');
		$this->db->where($subproject_id);
		return $this->db->get();
	}

	public function get_documentation_project($project_id) {
		$this->db->select('tb_photo.photo_id, tb_photo.ID_project as proj_ID, tb_photo.photo_url as url, tb_photo.created as photo_created, tb_project.project_id');
		$this->db->from('tb_photo');
		$this->db->join('tb_project', 'tb_photo.ID_project=tb_project.project_id', 'left');
		$this->db->where(['tb_photo.ID_project' => $project_id, 'tb_photo.ID_subproject' => NULL]);
		return $this->db->get();
	}

	public function get_documentation_subproject($project_id, $subproject_id) {
		$this->db->select('tb_photo.photo_id, tb_photo.ID_project as proj_ID, tb_photo.photo_url as url, tb_photo.created as photo_created, tb_project.project_id');
		$this->db->from('tb_photo');
		$this->db->join('tb_project', 'tb_photo.ID_project=tb_project.project_id', 'left');
		$this->db->where(['tb_photo.ID_project' => $project_id, 'tb_photo.ID_subproject' => $subproject_id]);
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

	public function get_riwayat_filter($bulan_awal, $bulan_akhir, $comp_id) {
		$this->db->select($this->_columns1());
		$this->db->from($this->tb_project);
		$this->db->join($this->tb_company, 'tb_company.company_id=tb_project.ID_company', 'left');
		$this->db->join($this->tb_users, 'tb_users.user_id=tb_project.ID_pm', 'left');
		$this->db->where([
			'tb_project.ID_company' 		=> $comp_id,
			'tb_project.project_status'	=> 'finish',
			'tb_project.project_deadline_month >=' => $bulan_awal,
			'tb_project.project_deadline_month <=' => $bulan_akhir
		]);
		return $this->db->get();
	}
}