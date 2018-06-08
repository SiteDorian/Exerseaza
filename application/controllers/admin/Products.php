<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->lang->load('admin/products');
        $this->lang->load('admin/categories');

        /* Load models  */
        $this->load->model('products_model');
        $this->load->model('images_model');
        $this->load->model('categories_model');

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_products'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_users'), 'admin/products');
    }


    public function index()
    {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Get all products */
            $this->data['products'] = $this->products_model->getAll();

            $this->data['images'] = $this->images_model->get_main();


            /* Load Template */
            $this->template->admin_render('admin/products/index', $this->data);
        }
    }


    public function create()
    {
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_products_create'), 'admin/products/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();


        /* Validate form input */
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('description', 'Description');
        $this->form_validation->set_rules('category', 'Category', 'required');

        $categories = $this->categories_model->getAll();

        if ($this->form_validation->run() == true) {
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $description = $this->input->post('description');
            $category = $this->input->post('category');
        }

        if ($this->form_validation->run() == true && $this->products_model->add($name, $price, $description,
                $category)) {
            redirect('admin/products', 'refresh');
        } else {
            $this->data['options'] = array();

            foreach ($categories as $key => $value) {
                $this->data['options'][$value['id']] = $value['name'];
                //array_push($this->data['options'], ($value['id'] => $value['name']) );
            }

            $this->data['name'] = array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['price'] = array(
                'name' => 'price',
                'id' => 'price',
                'type' => 'number',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('price'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('description'),
                'placeholder' => 'Enter product description. (HTML tags are accepted)'
            );
            $this->data['category'] = array(
                'name' => 'category',
                'id' => 'category',
                'type' => 'number',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('category'),
            );


            /* Load Template */
            $this->template->admin_render('admin/products/create', $this->data);
        }
    }


    public function delete()
    {
        return;
        /* Load Template */
        //$this->template->admin_render('admin/users/delete', $this->data);
    }


    public function edit($id)
    {
        $id = (int)$id;

        if (!$this->ion_auth->logged_in() OR (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_products_edit'), 'admin/products/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();


        /* Validate form input */
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('description', 'Description');
        $this->form_validation->set_rules('category', 'Category', 'required');

        $categories = $this->categories_model->getAll();
        $product = $this->products_model->getProduct($id);
        $price = preg_replace('~[\\\\/:*?$,"<>|]~', null, $product->price);

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $price = $this->input->post('price');
                $description = $this->input->post('description');
                $category = $this->input->post('category');
            }

            if ($this->form_validation->run() == true && $this->products_model->modify($id, $name, $price, $description,
                    $category)) {
                redirect('admin/products', 'refresh');
            }
        }

        $this->data['options'] = array();

        foreach ($categories as $key => $value) {
            $this->data['options'][$value['id']] = $value['name'];
            //array_push($this->data['options'], ($value['id'] => $value['name']) );
        }

        $this->data['product'] = $product;

        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('name', $product->name)
        );
        $this->data['price'] = array(
            'name' => 'price',
            'id' => 'price',
            'type' => 'number',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('price', $price),
        );
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('description', $product->description)
        );
        $this->data['category'] = array(
            'name' => 'category',
            'id' => 'category',
            'type' => 'number',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('category')
        );


        /* Load Template */
        $this->template->admin_render('admin/products/edit', $this->data);

    }


}
