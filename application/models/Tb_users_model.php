<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_users_model extends CI_Model {
	public function show(){
		$this->db->order_by('id', 'desc');
		return $this->db->get('tb_users')->result();
	}
	public function insert($value){
		if($this->db->insert('tb_users', $value)){
			return true;
		}
		return false;
	}
	public function update($value, $id){
		$this->db->where('id', $id);
		if($this->db->update('tb_users', $value)){
			return true;
		}
		return false;
	}
	public function delete($id){
		$this->db->where('id', $id);
		if($this->db->delete('tb_users')){
			return true;
		}
		return false;
	}
}