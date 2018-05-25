<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cart_model');
    }

    public function index()
    {
        return;
    }

    public function ajaxGet()
    {
        if (!$this->session->userdata()) {
            echo json_encode([
                'html' => 'error, not set user data!',
                'success' => 0
            ]);
            return false;
        }

        $user_data = $this->session->userdata();

        if (!$user_data['id']){
            echo json_encode([
                'html' => "Error, not set user id!",
                'success' => 0
            ]);
            return false;
        }

        $items = $this->cart_model->getCart($user_data['id']);

        if (!$items){
            echo json_encode([
                'html' => 'Error, not items!',
                'success' => 0
            ]);
            return false;
        }

        echo json_encode([
            'html' => $items,
            'success' => 1
        ]);
        return true;
    }

    public function ajaxUpdate()
    {
        $result = $this->cart_model->updateCart($_POST['items']);
        echo json_encode([
            'html' => $result,
            'success' => 1
        ]);
        return true;
    }

    public function ajaxRemove()
    {
        $result = $this->cart_model->removeItem($_POST['id']);
        echo json_encode([
            'html' => $result,
            'success' => 1
        ]);
        return true;
    }


}