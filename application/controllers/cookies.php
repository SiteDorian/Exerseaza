<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Cookies extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }


    public function index()
    {
        if (isset($_COOKIE)){
            print_r($_COOKIE);
        } else {
            echo "Cookies not set..";
        }

        echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
        echo '<pre>' . base_url() . '</pre>';
    }


}