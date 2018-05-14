<?php
defined('BASEPATH') or exit('No direct script access allowed');

$GLOBALS = array(
    'category' => "#"
);

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
    public function index()
    {
        $this->load->view('inc/header');

        $this->load->view('login');

        $categories = $this->categories_model->getAll();

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'products'
        ]);


        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $GLOBALS['category'] = $category;
        } else {
            $category = null;
            $GLOBALS['category'] = $category;
        }

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

    public function ajaxSortingProduct()
    {
        $sort = "#";

        if ($_POST) {
            $sort = $_POST['sort'];
            switch ($sort) {
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

            if (isset($_POST['category'])) {
                $category = $_POST['category'];
            } else {
                $category = null;
            }

            $products = $this->products_model->get($category, $sort);

            $images = $this->images_model->get($category);

            $main_images = $this->images_model->get_main($category);
            $rating = $this->products_model->getRating();

            echo json_encode([
                'html' => $this->load->view('ajax/product_list',
                    ['products' => $products, 'images' => $images, 'main_images' => $main_images, 'rating' => $rating],
                    true),
                'success' => 1
            ]);

        }


    }

}