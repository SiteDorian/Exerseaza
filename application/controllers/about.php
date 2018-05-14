<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class About extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $this->load->view('inc/header');

            $this->load->view('login');

            $categories = $this->categories_model->getAll();

            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'about'
            ]);

            $this->load->view('about_body');

            $this->load->view('inc/footer');

        }

    }
