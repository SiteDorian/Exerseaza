<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('inc/header');

        if ($this->session->userdata('validated')) {
            $this->load->view('user',
                ['name' => $this->session->userdata('name'), 'email' => $this->session->userdata('email')]);
        } else {
            $this->load->view('login');
        }

        $categories = $this->categories_model->getAll();

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'mail'
        ]);

        $this->load->view('mail_body');

        $this->load->view('inc/footer');

    }

}
