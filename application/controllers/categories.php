<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Categories extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('categories_model');
        }

        function index()
        {
            $rez = $this->categories_model->categories_list();
            if ($rez['status']==200)
            {
                if ($rez) print_r($rez['content']);
                 else return array('status'=>400, 'message'=>'No data');
            }
            else
            {
                return array('status'=>400, 'message'=>'error');
            }
        }
    }