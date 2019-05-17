<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_settings_model extends CI_Model {
	public function get(){
		$this->db->where('id', 1);
		return $this->db->get('tb_settings')->row();
	}
	public function show(){
		$this->db->order_by('id', 'desc');
		return $this->db->get('tb_settings')->result();
	}
	public function update($value, $id){
		$this->db->where('id', $id);
		if($this->db->update('tb_settings', $value)){
			return true;
		}
		return false;
	}
}