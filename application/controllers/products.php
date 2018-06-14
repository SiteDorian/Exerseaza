<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Products extends CI_Controller
{
    public $category = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('products_model');
        $this->load->model('images_model');
    }

    /**
     *
     */

//    function _remap($param) {
//        $this->index($param);
//    }

    function _remap($method)
    {
        $param_offset = 2;
        // Default to index
        if (!method_exists($this, $method)) {
            // We need one more param
            $param_offset = 1;
            $method = 'index';
        }
        // Since all we get is $method, load up everything else in the URI
        $params = array_slice($this->uri->rsegment_array(), $param_offset);
        // Call the determined method with all params
        call_user_func_array(array($this, $method), $params);
    }


    public function index($category = null, $page = 1)
    {
        $category = urldecode($category);
        $this->load->view('inc/header');

        $this->load->model('Paginator_model');

        $sort=null;

        $order=0;

        if (isset($_SESSION['order'])) {
            $order = $_SESSION['order'];
            switch ($_SESSION['order']) {
                case "1":
                    $sort = " order by id";
                    break;
                case "2":
                    $sort = " order by id";
                    break;
                case "3":
                    $sort = " order by created_at desc";
                    break;
                case "4":
                    $sort = " order by price asc";
                    break;
                case "5":
                    $sort = " order by price desc";
                    break;
                default:
                    $sort = " order by price";
            }
        }

        $results = $this->Paginator_model->getData($category, $page, 2, $sort);
        $links = 5;

//        $this->load->view('pagon_list', [
//            'html' => $this->Paginator_model->createLinks($links, 'pagination pagination-sm'),
//            'data' => $results,
//            'category' => $category,
//            'sort' => $order
//        ]);

        $categories = $this->categories_model->getAll();

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'products'
        ]);



        $images = $this->images_model->get($category);

        $main_images = $this->images_model->get_main($category);

        $rating = $this->products_model->getRating();

        $this->load->view('products_body',
            [
                'html' => $this->Paginator_model->createLinks($links, 'pagination pagination-sm'),
                'products' => $results,
                'images' => $images,
                'main_images' => $main_images,
                'category' => $category,
                'rating' => $rating,
                'sort' => $order
            ]);

        $this->load->view('inc/footer');

    }

    public function ceva($category = null, $page = 1)
    {
        $category = urldecode($category);
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
            'active_category' => 'products'
        ]);


//        if (isset($_GET['category'])) {
//            $category = $_GET['category'];
//            $GLOBALS['category'] = $category;
//        } else {
//            $category = null;
//            $GLOBALS['category'] = $category;
//        }

        $products = $this->products_model->get($category, ' order by id');

        $images = $this->images_model->get($category);

        $main_images = $this->images_model->get_main($category);

        $rating = $this->products_model->getRating();

        $this->load->view('products_body',
            [
                'products' => $products,
                'images' => $images,
                'main_images' => $main_images,
                'category' => $category,
                'rating' => $rating
            ]);

        $this->load->view('inc/footer');
    }

//    public function ajaxSortingProduct()
//    {
//        $sort = "#";
//
//        if ($_POST) {
//            $sort = $_POST['sort'];
//            switch ($sort) {
//                case "1":
//                    $sort = " order by id";
//                    break;
//                case "2":
//                    $sort = " order by id";
//                    break;
//                case "3":
//                    $sort = " order by created_at desc";
//                    break;
//                case "4":
//                    $sort = " order by price asc";
//                    break;
//                case "5":
//                    $sort = " order by price desc";
//                    break;
//                default:
//                    $sort = " order by price";
//            }
//
//            if (isset($_POST['category'])) {
//                $category = $_POST['category'];
//                //$category=urldecode($category);
//            } else {
//                $category = null;
//            }
//
//            $products = $this->products_model->get($category, $sort);
//
//            $images = $this->images_model->get($category);
//
//            $main_images = $this->images_model->get_main($category);
//            $rating = $this->products_model->getRating();
//
//            echo json_encode([
//                'html' => $this->load->view('ajax/product_list',
//                    ['products' => $products, 'images' => $images, 'main_images' => $main_images, 'rating' => $rating],
//                    true),
//                'success' => 1
//            ]);
//        }
//    }

    public function ajaxTestSortingProduct()
    {

        if (isset($_POST)) {
            $sort = $_POST['sort'];
            $_SESSION['order'] = $sort;



            echo json_encode([
                'success' => 1
            ]);
            return;
        }
    }

}
