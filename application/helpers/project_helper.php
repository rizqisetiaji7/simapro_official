<?php 
function countProjectPM($pm_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project');
	$ci->db->where(['ID_pm' => $pm_id, 'project_status' => 'on_progress']);
	return $ci->db->count_all_results();
}

function countProjectFinish($company_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project');
	$ci->db->where(['ID_company' => $company_id, 'project_status' => 'finish']);
	return $ci->db->count_all_results();
}

function countProjectOnProgress($company_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project');
	$ci->db->where(['ID_company' => $company_id, 'project_status' => 'on_progress']);
	return $ci->db->count_all_results();
}

function countProjectArchive($company_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project');
	$ci->db->where(['ID_company' => $company_id, 'project_archive' => 1]);
	return $ci->db->count_all_results();
}

function count_project_pm($projectStatus = 'on_progress') {
	$company_id = user_company()->company_id;
	$pm_id = user_company()->user_id;
	$ci =& get_instance();
	$ci->db->from('tb_project');
	if ($projectStatus == 'on_progress') {
		$ci->db->where(['ID_company' => $company_id, 'ID_pm' => $pm_id, 'project_status' => 'on_progress']);
	} else if ($projectStatus == 'finish') {
		$ci->db->where(['ID_company' => $company_id, 'ID_pm' => $pm_id, 'project_status' => 'finish']);
	} else if ($projectStatus == 'archive') {
		$ci->db->where(['ID_company' => $company_id, 'ID_pm' => $pm_id, 'project_archive' => 1]);
	}
	return $ci->db->count_all_results();
}

function getCountDocumentation($project_id, $subproject_id = NULL) {
	$ci =& get_instance();
	$ci->db->from('tb_photo');
	$ci->db->where(['ID_project' => $project_id, 'ID_subproject' => $subproject_id]);
	return $ci->db->count_all_results();
}

function tampilSubelemen($subproject_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project_task');
	$ci->db->join('tb_priority', 'tb_project_task.ID_priority=tb_priority.priority_id');
	$ci->db->where(['ID_subproject' => $subproject_id]);
	$ci->db->order_by('project_task_id', 'DESC');
	$query = $ci->db->get();
	$data = [
		'total_tasks'	=> $query->num_rows(),
		'subelemen'		=> $query->result_array()
	];
	return $data;
}