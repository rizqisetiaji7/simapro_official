<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {
	private $tb_company = 'tb_company';
	private $tb_users = 'tb_users';

	public function get_company($user_id) {
		$this->db->from($this->tb_company);
		$this->db->join($this->tb_users, 'tb_company.company_id=tb_users.ID_company', 'left');
		$this->db->where(['tb_users.user_id' => $user_id]);
		return $this->db->get();
	}

	public function get_subcompany($parent_id) {
		$this->db->from('tb_company');
		$this->db->where(['tb_company.comp_parent_id' => $parent_id]);
		return $this->db->get();
	}

	public function insert_comp($post) {
		// Date Since Company
      $date_comp = explode('-', $post['comp_since']);
      $date_comp = implode($date_comp);

      $data = [
         'comp_parent_id'  => $post['company_id'],
         'comp_code_ID'    => 'COMP'.$date_comp.random_string('numeric', 8),
         'comp_name'       => $post['comp_name'],
         'comp_logo'       => $post['logo'],
         'comp_slug'       => url_title($post['comp_name'], '-', TRUE),
         'comp_email'      => $post['comp_email'],
         'comp_phone'      => $post['comp_phone'],
         'comp_address'    => $post['comp_address'] == '' ? NULL : $post['comp_address'],
         'comp_type'       => $post['comp_type'],
         'comp_desc'       => $post['comp_desc'] == '' ? NULL : $post['comp_desc'],
         'comp_since'      => $post['comp_since'],
         'created'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ];
      $this->db->insert('tb_company', $data);
	}

	public function update_company($post) {
		// Date Since Company
      $date_comp = explode('-', $post['comp_since']);
      $date_comp = implode($date_comp);
      $comp_code = base64_decode($post['comp_code_ID']) == '' ? 'COMP'.$date_comp.random_string('numeric', 8) : base64_decode($post['comp_code_ID']);

      $data = [
         'comp_code_ID'    => $comp_code,
         'comp_name'       => $post['comp_name'],
         'comp_logo'       => $post['comp_logo'],
         'comp_slug'       => url_title($post['comp_name'], '-', TRUE),
         'comp_email'      => $post['comp_email'],
         'comp_phone'      => $post['comp_phone'],
         'comp_address'    => $post['comp_address'],
         'comp_type'       => $post['comp_type'],
         'comp_desc'       => $post['comp_desc'],
         'comp_since'      => $post['comp_since'],
         'updated'         => date('Y-m-d H:i:s', now('Asia/Jakarta'))
      ];

      $this->db->where(['company_id' => $post['company_id'], 'comp_parent_id' => $post['comp_parent_id']]);
      $this->db->update($this->tb_company, $data, ['company']);
	}

   public function get_director($company_id, $user_role) {
      $this->db->select('tb_company.company_id, tb_company.comp_parent_id, tb_users.user_fullname, tb_users.user_unique_id, tb_users.user_role, tb_users.user_profile, tb_users.user_email');
      $this->db->from($this->tb_users);
      $this->db->join($this->tb_company, 'tb_users.ID_company=tb_company.company_id', 'left');
      $this->db->where(['tb_users.ID_company' => $company_id, 'user_role' => $user_role]);
      return $this->db->get();
   }
}