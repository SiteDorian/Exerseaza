<?php

class Form extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_model');
    }

    public function index()
    {

    }

    public function registration()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');


        if ($this->form_validation->run() == FALSE)
        {

            $data['register_errors'] = validation_errors();

            $this->load->view('inc/header');

            $this->load->view('login', $data);


            $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'home'
            ]);

            $this->load->view('home_body');

            $this->load->view('inc/footer');
        }
        else
        {
            //$this->load->view('formsuccess');

            $registrer = $this->registration_model->register($_POST);
        }
    }

    public function login()
    {


        $this->form_validation->set_rules('email_login', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');


        if ($this->form_validation->run() == FALSE)
        {
            $data['login_errors'] = validation_errors();
            $this->load->view('inc/header');

            $this->load->view('login', $data);


            $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'home'
            ]);

            $this->load->view('home_body');

            $this->load->view('inc/footer');
        }
        else
        {
            $this->load->view('formsuccess');
        }
    }
}