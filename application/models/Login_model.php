<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function login($where)
    {
        if($this->db->get_where('tb_users', $where)->num_rows() > 0){
            return true;
        }
        return false;
    }

}