<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('status_login_generator_map')){
            redirect(base_url('index.php/Home'));
        }
        $this->load->model('Tb_settings_model');
        $this->load->model('Login_model');
    }
    public function index()
    {
        $data['tb_settings'] = $this->Tb_settings_model->get();
        $this->load->view('Login_view', $data);
    }
    public function login()
    {
        $post = $this->input->post();
        if($post){
            $where = array(
                "username"=>$post['username'],
                "password"=>md5($post['password'])
            );
            if($this->Login_model->login($where)){
                $array = array(
                    'status_login_generator_map' => true
                );
                $this->session->set_userdata($array);
                redirect(base_url('index.php/Home'));
            } else {
                $this->session->set_flashdata('msg', 'Username atau Password Salah!');
                redirect(base_url('index.php/Login'));
            }
        }        
    }
}