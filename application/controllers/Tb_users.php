<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tb_users extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('status_login_generator_map')){
            redirect(base_url('index.php/Login'));
        }
		$this->load->model('Tb_settings_model');
		$this->load->model('Tb_users_model');
	}
	public function index(){
		$data['tb_settings'] = $this->Tb_settings_model->get();
		$data['page_view'] = 'Tb_users_view';
		$data['tb_users'] = $this->Tb_users_model->show();
		$this->load->view('template', $data);
	}
	public function insert(){
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$post = $this->input->post();
			$post['password'] = md5($post['password']);
			if($this->Tb_users_model->insert($post)){
				$this->session->set_flashdata('success','Berhasil disimpan!');
			} else {
				$this->session->set_flashdata('failed','Gagal disimpan!');
			}
		}
		redirect(base_url('index.php/Tb_users'));
	}
	public function update(){
		$this->form_validation->set_rules('id', 'id', 'trim|required');
		$this->form_validation->set_rules('username', 'username', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$post = $this->input->post();
			$post['password'] = md5($post['password']);
			if($this->Tb_users_model->update($post, $this->input->post('id'))){
				$this->session->set_flashdata('success','Berhasil diubah!');
			} else {
				$this->session->set_flashdata('failed','Gagal diubah!');
			}
			redirect(base_url('index.php/Tb_users'));
		}
	}
	public function delete(){
		if($this->Tb_users_model->delete($this->input->post('id'))){
			$this->session->set_flashdata('success','Berhasil dihapus!');
		} else {
			$this->session->set_flashdata('failed','Gagal dihapus!');
		}
		redirect(base_url('index.php/Tb_users'));
	}
}