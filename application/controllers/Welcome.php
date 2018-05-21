<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    /**
     * Dorian Gotonoaga
     */

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

//        $categories['active']='home'; //indica meniul activ

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'home'
        ]);

        $this->load->view('home_body');

        $this->load->view('inc/footer');

    }


}
