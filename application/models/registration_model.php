<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('email');
    }

    public function register($user)
    {
        $email = $user['email'];
        $name = $user['username'];
        $password = $user['password'];
        $passconf = $user['passconf'];

        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => md5($password),
            'status' => true,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        );

        $this->db->insert('users', $data);

        return $this->db->affected_rows();

    }

    public function facebookRegister($user)
    {
        $data = array(
            'fid' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => true,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        );

        $this->db->insert('users', $data);

        return $this->db->affected_rows();
    }

    public function googleRegister($user)
    {
        $data = array(
            'gid' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => true,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        );

        $this->db->insert('users', $data);

        return $this->db->affected_rows();
    }
}