<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_settings extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('status_login_generator_map')){
            redirect(base_url('index.php/Login'));
        }
		$this->load->model('Tb_settings_model');
	}
	public function index(){
		$data['tb_settings'] = $this->Tb_settings_model->get();
		$data['page_view'] = 'Tb_settings_view';
		$data['tb_data_settings'] = $this->Tb_settings_model->show();
		$data['skins'] = array(
			'skin-blue',
			'skin-blue-light',
			'skin-yellow',
			'skin-yellow-light',
			'skin-green',
			'skin-green-light',
			'skin-purple',
			'skin-purple-light',
			'skin-red',
			'skin-red-light',
			'skin-black',
			'skin-black-light'
		);
		$this->load->view('template', $data);
	}
	public function update(){
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		$this->form_validation->set_rules('title', 'title', 'trim|required');
		$this->form_validation->set_rules('theme', 'theme', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			if($this->Tb_settings_model->update($this->input->post(), $this->input->post('id'))){
				$this->session->set_flashdata('success','Berhasil diubah!');
			} else {
				$this->session->set_flashdata('failed','Gagal diubah!');
			}
			redirect(base_url('index.php/Tb_settings'));
		}
	}
}