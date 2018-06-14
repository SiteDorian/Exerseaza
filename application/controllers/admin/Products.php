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
        $this->breadcrumbs->unshift(1, lang('menu_products'), 'admin/products');
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


    public function edit($id)
    {
        $id = (int)$id;

        if (!$this->ion_auth->logged_in() OR (!$this->ion_auth->is_admin())) {
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

    public function images($id)
    {
        $id = (int)$id;

        if (!$this->ion_auth->logged_in() OR (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        /* Data */
        $this->data['images'] = $this->images_model->get_product_images($id);
        $this->data['productID'] = $id;

        $this->data['product']= $this->products_model->getProduct($id);

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_products_edit'), 'admin/products/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        if ($this->session->flashdata('delete_info')) {
            $this->data['delete_info'] = $this->session->flashdata('delete_info');
        }

        if ($this->session->flashdata('upload_info')) {
            $this->data['upload_info'] = $this->session->flashdata('upload_info');
        }

        if ($this->session->flashdata('image_info')) {
            $this->data['image_info'] = $this->session->flashdata('image_info');
        }

        if (isset($_SESSION['delete_info'])) {
            unset($_SESSION['delete_info']);
        }

        if (isset($_SESSION['upload_info'])) {
            unset($_SESSION['upload_info']);
        }

        if (isset($_SESSION['image_info'])) {
            unset($_SESSION['image_info']);
        }


        /* Load Template */
        $this->template->admin_render('admin/products/images', $this->data);

    }

    public function delete($id, $id_product = null)
    {
        $this->load->helper("file");

        $id = (int)$id;

        if ($path = $this->images_model->delete($id)) {
            $path = realpath($path);
            //delete_files($path);
            unlink($path);
            $this->session->set_flashdata('delete_info', 'Image deleted successfull.');
        } else {
            $this->session->set_flashdata('delete_info', 'Image was not deleted!');
        }

        /* Load Template */
        redirect('admin/products/images/' . $id_product, 'refresh');
    }

    public function upload($id_product = null)
    {
        $id_product = $id_product;

        if (!$this->ion_auth->logged_in() OR (!$this->ion_auth->is_admin())) {
            redirect('auth', 'refresh');
        }

        if (isset($_POST['btn']) && $_FILES['f1']['tmp_name'] != "" && $_FILES['f1']['tmp_name'] != null) {


//            //insereaza in baza de date
//            $image = file_get_contents($_FILES['f1']['tmp_name']);
////            $image = addslashes(file_get_contents($_FILES['f1']['tmp_name']));
//
////            $base64 = base64_encode($image);
//            $escaped = pg_escape_bytea($image);
//
//            if ($this->images_model->upload($id_product, $escaped)) {
//                $this->session->set_flashdata('upload_info', "New image uploaded successfully!");
//            } else {
//                $this->session->set_flashdata('upload_info', "Error, nu sa incarcat imaginea!");
//            }
            if (!is_dir('images/product/'.$id_product)) {
                mkdir('./images/product/' . $id_product, 0777, TRUE);
            }

            $config['upload_path']          = './images/product/'. $id_product.'/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 6144;
            $config['max_width']            = 3000;
            $config['max_height']           = 3000;
            $new_name = time().$_FILES["f1"]['name'];
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('f1'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('upload_info', 'Error, image was not uploaded!');
            }
            else
            {
                if ($this->images_model->upload($id_product, $config['upload_path'].$new_name)) {
                    $this->session->set_flashdata('upload_info', "New image uploaded successfully!");
                } else {
                    $this->session->set_flashdata('upload_info', "Error, nu sa incarcat imaginea in database!");
                }
            }

            /* Load Template */
            redirect('admin/products/images/' . $id_product, 'refresh');
            return;
        }
        $this->session->set_flashdata('upload_info', "Error, not data!");
        redirect('admin/products/images', 'refresh');
        return;
    }

    public function set_main_image($imageID = null, $productID = null)
    {
        if (!$this->ion_auth->logged_in() OR (!$this->ion_auth->is_admin())) {
            redirect('auth', 'refresh');
        }
        $this->db->where('id_product', $productID);
        $this->db->where('is_main', true);
        $this->db->update('images', ['is_main' => false]);
        $rez = $this->db->affected_rows();

        $this->db->where('id', $imageID);
        if ($this->db->update('images', ['is_main' => true])) {
            if ($rez > 0) {
                $this->session->set_flashdata('image_info', 'Main image has been changed!');
            } else {
                $this->session->set_flashdata('image_info', 'Main image has been set!');
            }
        } else {
            $this->session->set_flashdata('image_info', 'Error, main image has not been set!');
        }

        /* Load Template */
        redirect('admin/products/images/' . $productID, 'refresh');

    }


}
