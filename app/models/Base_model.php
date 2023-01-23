<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model {
   public function get($table, $select='*', $where=null, $order=null, $limit=null, $offset=null) {
      $this->db->from($table);
      $this->db->select($select);
      $this->db->order_by($order);
      $this->db->limit($limit, $offset);
      if (!is_null($where)) {
         $this->db->where($where);
      }
      return $this->db->get();
   }

   public function get_join($table, $select='*', $where=null, $join=null) {
      $this->db->from($table);
      $this->db->select($select);

      if (!is_null($join)) {
         foreach($join as $j) {
            $this->db->join($j['table'], $j['cond'], $j['type']);
         }
      }
      
      if (!is_null($where)) {
         $this->db->where($where);
      }
      return $this->db->get();
   }

   public function save($table, $data, $batch=FALSE) {
      if ($batch != FALSE) {
         $this->db->insert_batch($table, $data);
      } else {
         $this->db->insert($table, $data);
      }
      return true;
   }

   public function update($table, $data, $where=null) {
      if (!is_null($where)) {
         $this->db->where($where);
      }
      $this->db->update($table, $data);
      return true;
   }

   public function delete($table, $where=null) {
      if (!is_null($where)) {
         $this->db->delete($table, $where);
      } else {
         $this->db->truncate($table);
      }
      return true;
   }
}