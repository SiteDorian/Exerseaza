<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model');
        $this->load->model('products_model');
    }

    public function index()
    {
        $this->load->view('inc/header');

        $categories = $this->categories_model->getAll();

        $categories['active']='products';

        $this->load->view('widgets/navigation', $categories);

        $products = $this->products_model->get($_GET['category']);

        $this->load->view('products_body', $products);

        $this->load->view('inc/footer');
    }

}