<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cart_model');
        $this->load->model('images_model');
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

    public function ajaxGetCheckout()
    {
        if (!$this->session->userdata()) {
            echo json_encode([
                'html' => 'error, not set user data!',
                'success' => 0
            ]);
            return;
        }

        $user_data = $this->session->userdata();

        if (!$user_data['id']){
            echo json_encode([
                'html' => "Error, not set user id!",
                'success' => 0
            ]);
            return;
        }

        $items = $this->cart_model->getCart($user_data['id']);
        $images = $this->images_model->get_main_checkout($user_data['id']); //get images from user Cart

        if ($items && $images) {
            echo json_encode([
                'items' => $items,
                'images' => $images,
                'success' => 1
            ]);
            return;
        }

        echo json_encode([
            'html' => "Internal error!",
            'success' => 0
        ]);
        return;
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

    public function ajaxUpdateItem()
    {
        $result = $this->cart_model->updateItem($_POST['product']);
        echo json_encode([
            'html' => $result,
            'success' => 1
        ]);
        return true;
    }

    public function ajaxAddItem()
    {
        $result = $this->cart_model->addItem($_POST['product']);
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