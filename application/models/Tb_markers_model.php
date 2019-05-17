<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_markers_model extends CI_Model {
	public function show($is_show=FALSE){
		if ($is_show==TRUE) {
			$this->db->where('show_flags',1);
		}
		$this->db->order_by('id', 'desc');
		return $this->db->get('tb_marker')->result();
	}
	public function insert($value){
		if($this->db->insert('tb_marker', $value)){
			return true;
		}
		return false;
	}
	public function update($value, $id){
		$this->db->where('id', $id);
		if($this->db->update('tb_marker', $value)){
			return true;
		}
		return false;
	}
	public function delete($id){
		$this->db->where('id', $id);
		if($this->db->delete('tb_marker')){
			return true;
		}
		return false;
	}
}