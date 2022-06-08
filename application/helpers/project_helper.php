<?php 

function subelemen_project($subproject_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project_task');
	$ci->db->join('tb_priority', 'tb_project_task.ID_priority=tb_priority.priority_id');
	$ci->db->where(['ID_subproject' => $subproject_id]);
	$ci->db->order_by('project_task_id', 'DESC');
	return $ci->db->get();
}

function subproject_progress($subproject_id, $total_subelemen = 0) {
	$ci =& get_instance();
	$ci->db->select("SUM(project_task_progress) as total_progress");
	$ci->db->from('tb_project_task');
	$ci->db->where(['ID_subproject' => $subproject_id]);
	$data = $ci->db->get()->row();
	$progress = !$data->total_progress ? 0 : $data->total_progress / $total_subelemen;
	$progress = $progress >= 100 ? 100 : $progress;
	return ceil($progress);
}

function countProjectPM($pm_id) {
	$ci =& get_instance();
	$ci->db->from('tb_project');
	$ci->db->where(['ID_pm' => $pm_id, 'project_status' => 'on_progress']);
	return $ci->db->count_all_results();
}