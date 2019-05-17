<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_data_polyline_model extends CI_Model {
	public function show(){
		$this->db->order_by('id', 'desc');
		return $this->db->get('tb_data_polyline')->result();
	}
	public function show_array($id_polyline){
		$this->db->where('id_polyline', $id_polyline);
		return $this->db->get('tb_data_polyline')->result();
	}
	public function insert($value){
		if($this->db->insert('tb_data_polyline', $value)){
			return true;
		}
		return false;
	}
	public function update($value, $id){
		$this->db->where('id', $id);
		if($this->db->update('tb_data_polyline', $value)){
			return true;
		}
		return false;
	}
	public function delete($id){
		$this->db->where('id', $id);
		if($this->db->delete('tb_data_polyline')){
			return true;
		}
		return false;
	}
	public function delete_array($id_polyline){
		$this->db->where('id_polyline', $id_polyline);
		if($this->db->delete('tb_data_polyline')){
			return true;
		}
		return false;
	}
}