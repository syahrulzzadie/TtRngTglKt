<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_polygon_model extends CI_Model {
	public function get($where)
	{
		$this->db->where($where);
		return $this->db->get('tb_polygon')->row();
	}
	public function show($is_show=FALSE){
		if ($is_show==TRUE) {
			$this->db->where('show_flags',1);
		}
		$this->db->order_by('id_kategori', 'asc');
		return $this->db->get('tb_polygon')->result();
	}
	public function insert($value){
		if($this->db->insert('tb_polygon', $value)){
			return true;
		}
		return false;
	}
	public function update($value, $id){
		$this->db->where('id', $id);
		if($this->db->update('tb_polygon', $value)){
			return true;
		}
		return false;
	}
	public function delete($id){
		$this->db->where('id', $id);
		if($this->db->delete('tb_polygon')){
			return true;
		}
		return false;
	}
	public function showWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('tb_polygon')->result();
	}
}