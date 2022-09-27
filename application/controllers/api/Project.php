<?php defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Project extends RestController {
	public function __construct() {
		parent::__construct();
		$this->load->model('api_model');
	}

	private function dataProjects($id=NULL, $status='finish', $limit=NULL) {
		$data = [];
		foreach($this->api_model->get_projects($id, $status, $limit) as $project) {
			$data[] = [
				'project'	=> [
					'project_id'	=> $project['project_id'],
					'project_code'	=> $this->str_secure->encryptid($project['code_ID']),
					'title'			=> $project['project_name'],
					'thumbnail'		=> $project['project_thumbnail'] == 'placeholder.jpg' ? base_url('assets/img/placeholder.jpg') : base_url('uploads/thumbnail/'.$project['project_thumbnail']),
					'address'		=> $project['project_address'],
					'description'	=> $project['project_description'],
					'start'			=> $project['project_start'] !== NULL ? datetimeIDN($project['project_start']) : NULL,
					'deadline'		=> $project['project_deadline'] !== NULL ? datetimeIDN($project['project_deadline']) : NULL,
					'end'			=> $project['project_current_deadline'] !== NULL ? datetimeIDN($project['project_current_deadline']) : NULL,
					'status'		=> $project['project_status'],
					'progress'		=> round($project['project_progress']).'%',
					'company'		=> [
						'company_code'	=> $this->str_secure->encryptid($project['comp_code']),
						'company_name'	=> $project['comp_name']
					],
					'pm'			=> [
						'pm_code'	 	=> $this->str_secure->encryptid($project['user_unique_id']),
						'pm_picture' 	=> $project['user_profile'] == 'default-avatar.jpg' ? base_url('assets/img/'.$project['user_profile']) : base_url('uploads/profile/'.$project['user_profile']),
						'pm_name'		=> $project['user_fullname']
					]
				]
			];
		}

		return $data;
	}

	public function index_get() {
		$id = $this->get('id');

		if (is_null($id)) {
			if ($this->dataProjects()) {
				$this->response([
					'status'	=> TRUE,
					'data'		=> $this->dataProjects(NULL, 'finish', 50)
				], 200);
			} else {
				$this->response([
					'status'	=> FALSE,
					'message'	=> 'Project Not Found'
				], 404);
			}
		} else {
			if ($this->dataProjects($id)) {
				$this->response([
					'status'	=> TRUE,
					'data'		=> $this->dataProjects($id)
				], 200);
			} else {
				$this->response([
					'status'	=> FALSE,
					'message'	=> 'Project '.$id.' Not Found'
				], 404);
			}
		}
	}
}