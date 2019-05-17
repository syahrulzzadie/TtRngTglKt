<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_markers extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('status_login_generator_map')){
            redirect(base_url('index.php/Login'));
        }
		$this->load->model('Tb_settings_model');
		$this->load->model('Tb_markers_model');
		$this->load->model('Tb_kategori_model');
	}
	public function index(){
		$data['tb_settings'] = $this->Tb_settings_model->get();
		$data['page_view'] = 'Tb_markers_view';
		$data['tb_kategori'] = $this->Tb_kategori_model->show();

		$markers = $this->Tb_markers_model->show();
		$array_markers = array();
		foreach ($markers as $key => $value) {
			$array_markers[$key] = new StdClass;
			$array_markers[$key]->id = $value->id;
			$array_markers[$key]->keterangan = $value->keterangan;
			$array_markers[$key]->link_cctv = $value->link_cctv;
			$array_markers[$key]->latitude = $value->latitude;
			$array_markers[$key]->longitude = $value->longitude;
			$array_markers[$key]->show_flags = ($value->show_flags > 0) ? 'checked="checked"':'';
		}
		$data['markers'] = $array_markers;

		$markers_latlng = $this->Tb_markers_model->show(TRUE);
		$array_markers_latlng = array();
		foreach ($markers_latlng as $key => $value) {
			$array_markers_latlng[$key] = new StdClass;
			$array_markers_latlng[$key]->keterangan = $value->keterangan;
			$array_markers_latlng[$key]->link_cctv = $value->link_cctv;
			$array_markers_latlng[$key]->latitude = $value->latitude;
			$array_markers_latlng[$key]->longitude = $value->longitude;
		}
		$data['markers_latlng'] = $array_markers_latlng;
		$this->load->view('template', $data);
	}
	public function insert(){
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
		$this->form_validation->set_rules('link_cctv', 'link_cctv', 'trim');
		$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
		$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$values = array(
				'id_kategori' => $this->input->post('id_kategori'),
				'keterangan' => $this->input->post('keterangan'),
				'link_cctv' => $this->input->post('link_cctv'),
				'latitude' => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude')
			);
			if($this->Tb_markers_model->insert($values)){
				$this->session->set_flashdata('success','Berhasil disimpan!');
			} else {
				$this->session->set_flashdata('failed','Gagal disimpan!');
			}
		}
		redirect(base_url('index.php/Tb_markers'));
	}
	public function update(){
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
		$this->form_validation->set_rules('link_cctv', 'link_cctv', 'trim');
		if($this->form_validation->run() == TRUE) {
			$set = array(
				'id_kategori' => $this->input->post('id_kategori'),
				'keterangan' => $this->input->post('keterangan'),
				'link_cctv' => $this->input->post('link_cctv')
			);
			if($this->Tb_markers_model->update($set, $this->input->post('id'))){
				$this->session->set_flashdata('success','Berhasil diubah!');
			} else {
				$this->session->set_flashdata('failed','Gagal diubah!');
			}
			redirect(base_url('index.php/Tb_markers'));
		}
	}
	public function is_show(){
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$show_flags = ($this->input->post('isShow') !== NULL) ? 1 : 0;
			if($this->Tb_markers_model->update(['show_flags'=>$show_flags], $this->input->post('id'))){
				$this->session->set_flashdata('success','Berhasil diubah!');
			} else {
				$this->session->set_flashdata('failed','Gagal diubah!');
			}
			redirect(base_url('index.php/Tb_markers'));
		}
	}
	public function delete(){
		if($this->Tb_markers_model->delete($this->input->post('id'))){
			$this->session->set_flashdata('success','Berhasil dihapus!');
		} else {
			$this->session->set_flashdata('failed','Gagal dihapus!');
		}
		redirect(base_url('index.php/Tb_markers'));
	}
}