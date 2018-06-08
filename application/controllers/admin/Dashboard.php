<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
    }


    public function index()
    {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        /* Title Page */
        $this->page_title->push(lang('menu_dashboard'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Data */
        $this->data['count_users'] = $this->dashboard_model->get_count_record('users');
        $this->data['count_groups'] = $this->dashboard_model->get_count_record('groups');
        $this->data['count_products'] = $this->dashboard_model->get_count_record('products');
        $this->data['count_categories'] = $this->dashboard_model->get_count_record('categories');
        $this->data['disk_totalspace'] = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
        $this->data['disk_freespace'] = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
        $this->data['disk_usespace'] = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
        $this->data['disk_usepercent'] = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, false);
        $this->data['memory_usage'] = $this->dashboard_model->memory_usage();
        $this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(true);
        $this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(true, false);


        /* TEST */
        $this->data['url_exist'] = is_url_exist('http://www.domprojects.com');


        /* Load Template */
        $this->template->admin_render('admin/dashboard/index', $this->data);

    }
}
