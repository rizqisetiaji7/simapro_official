<?php 

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