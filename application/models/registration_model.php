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



    }
}