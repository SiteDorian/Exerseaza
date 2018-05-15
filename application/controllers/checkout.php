<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
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

        $this->load->view('login');

        $categories = $this->categories_model->getAll();

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'checkout'
        ]);

        $this->load->view('checkout_body');

        $this->load->view('inc/footer');
    }

}