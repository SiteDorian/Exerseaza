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
        $this->load->model('cart_model');
        $this->load->model('images_model');
    }

    public function index()
    {
        $this->load->view('inc/header');

        if ($this->session->userdata('validated')) {
            $this->load->view('user',
                ['name' => $this->session->userdata('name'), 'email' => $this->session->userdata('email')]);
        } else {
            //$this->load->view('login');
            redirect("welcome");
            return;
        }

        $categories = $this->categories_model->getAll();

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'checkout'
        ]);

        $user_data = $this->session->userdata();
        $userID = $user_data['id'];

        $items = $this->cart_model->getCheckout($userID);
        $images = $this->images_model->get_main_checkout($userID); //get product images from user Cart

        $this->load->view('checkout_body', ['items'=>$items, 'images'=>$images]);

        $this->load->view('inc/footer');
    }

}