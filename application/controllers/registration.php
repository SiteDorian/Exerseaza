<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD']!=='POST'){
            return 0;
        }

        $name = $_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];

        $this->registration_model($name, $email, $password);
    }
}