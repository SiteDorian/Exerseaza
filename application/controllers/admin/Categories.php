<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('admin/users');

        $this->lang->load('admin/categories');

        $this->load->model('categories_model');

        $this->page_title->push('Categories management');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'categories', 'admin/categories');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Get all categories */
            $this->data['categories'] = $this->categories_model->getAll('id_parent');

            /* Load Template */
            $this->template->admin_render('admin/categories/index', $this->data);
        }
    }

    public function create()
    {
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create category', 'admin/users/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Variables */
        $tables = $this->config->item('tables', 'ion_auth');

        /* Validate form input */
        $this->form_validation->set_rules('name', 'Category name', 'required');

        /* Data */
        $categories = $this->categories_model->getAll();
        $this->data['options'] = array(
            '#' => null,
        );

        foreach ($categories as $key => $value) {
            $this->data['options'][$value['id']] = $value['name'];
        }
        /* Data */


        if ($this->form_validation->run() == true) {
            $name = strtolower($this->input->post('name'));
            $parent = $this->input->post('parent');
        }

        if ($this->form_validation->run() == true && $this->categories_model->add($name, $parent)) {
            redirect('admin/categories', 'refresh');
        } else {
            $this->data['message'] = (validation_errors() ? validation_errors() : null);

            $this->data['name'] = array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['parent'] = array(
                'name' => 'parent',
                'id' => 'parent',
                'type' => 'number',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('parent'),
            );

            /* Load Template */
            $this->template->admin_render('admin/categories/create', $this->data);
        }
    }

    public function delete()
    {
        /* Load Template */
        $this->template->admin_render('admin/categories/delete', $this->data);
    }

    public function edit($id)
    {
        $id = (int)$id;

        if (!$this->ion_auth->logged_in() OR (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_users_edit'), 'admin/categories/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Data */
        $category = $this->categories_model->get($id)->row();
        $categories = $this->categories_model->getAll();

        /* Validate form input */
        $this->form_validation->set_rules('name', 'Category name', 'required');
        $this->form_validation->set_rules('parent', 'Category parent');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() == true) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'id_parent' => $this->input->post('parent')
                );
                if ($data['id_parent']=="#") $data['id_parent']=null;


                if ($this->categories_model->update($id, $data)) {
                    redirect('admin/categories', 'refresh');
                } else {
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }


        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['category'] = $category;

        $this->data['options'] = array(
            '#' => null,
        );

        foreach ($categories as $key => $value) {
            $this->data['options'][$value['id']] = $value['name'];
            //array_push($this->data['options'], ($value['id'] => $value['name']) );
        }

        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('name', $category->name)
        );
        $this->data['parent'] = array(
            'name' => 'parent',
            'id' => 'parent',
            'type' => 'number',
            'class' => 'form-control',
            'value' => $this->form_validation->set_value('parent', $category->id_parent)
        );

        /* Load Template */
        $this->template->admin_render('admin/categories/edit', $this->data);
    }


}