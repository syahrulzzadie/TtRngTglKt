<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_data_polygon_model extends CI_Model {
	public function show(){
		return $this->db->get('tb_data_polygon')->result();
	}
	public function show_array($id_polygon){
		$this->db->where('id_polygon', $id_polygon);
		return $this->db->get('tb_data_polygon')->result();
	}
	public function insert($value){
		if($this->db->insert('tb_data_polygon', $value)){
			return true;
		}
		return false;
	}
	public function update($value, $id){
		$this->db->where('id', $id);
		if($this->db->update('tb_data_polygon', $value)){
			return true;
		}
		return false;
	}
	public function delete($id){
		$this->db->where('id', $id);
		if($this->db->delete('tb_data_polygon')){
			return true;
		}
		return false;
	}
	public function delete_array($id_polygon){
		$this->db->where('id_polygon', $id_polygon);
		if($this->db->delete('tb_data_polygon')){
			return true;
		}
		return false;
	}
}