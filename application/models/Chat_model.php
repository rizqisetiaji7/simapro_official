<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
	private $tb_chat = 'tb_livechat';

	public function get_message($data=NULL) {
		$query = "SELECT * FROM tb_livechat WHERE (ID_project=".$data['project_id']." AND ID_sender=".$data['from_user']." AND ID_receiver=".$data['to_user'].") OR (ID_project=".$data['project_id']." AND ID_sender=".$data['to_user']." AND ID_receiver=".$data['from_user'].")";
		return $this->db->query($query);
	}

	public function get_user($data=NULL) {
		$this->db->from('tb_users');
		$this->db->where(['user_id' => $data['user_id']]);
		return $this->db->get();
	}

	public function get_project($project_id=NULL) {
		$this->db->from('tb_project');
		$this->db->where(['project_id' => $project_id]);
		return $this->db->get();
	}
}