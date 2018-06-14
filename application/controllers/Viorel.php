<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viorel extends CI_Controller
{

    /**
     * Dorian Gotonoaga
     */

    public function __construct()
    {
        parent::__construct();

        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('categories_model');

        $this->load->helper('Json_output_helper');
    }

    public function index()
    {
        return;
    }

    public function products()
    {
        json_output(200, $this->products_model->get(null));
    }

    public function category()
    {
        json_output(200, $this->categories_model->getAll());
    }

    public function images($category=null)
    {
        json_output(200, $this->images_model->get_main($category));
    }
}