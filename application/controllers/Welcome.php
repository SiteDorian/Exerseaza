<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Dorian Gotonoaga
	 */

	public function __construct()
    {
        parent::__construct();
        $this->load->model("categories_model");
    }

    public function index()
	{
        $this->load->view('inc/header');

        //$this->load->view('login');


        $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'home'
        ]);

	    $this->load->view('home_body');

        $this->load->view('inc/footer');

	}

	public function home()
    {
        $this->load->view('inc/header');

        $categories = $this->categories_model->getAll();

        $categories['active']='home'; // indica meniul activ

        $this->load->view('home_body', $categories);

        $this->load->view('inc/footer');

    }
}
