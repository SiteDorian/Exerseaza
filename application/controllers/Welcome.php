<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    /**
     * Dorian Gotonoaga
     */

    public function __construct()
    {
        parent::__construct();
        require_once 'vendor/autoload.php';

    }

    public function index()
    {
        $this->load->view('inc/header');



        if ($this->session->userdata('validated')) {
            $this->load->view('user',
                ['name' => $this->session->userdata('name'), 'email' => $this->session->userdata('email')]);
        } else {
            $client = new Google_Client();
            $client->setAuthConfig('client_secret.json');
            $client->setAccessType("online");        // offline access
            $client->setIncludeGrantedScopes(true);   // incremental auth
            //$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
            $client->setScopes(array('profile', 'email', 'openid'));
            $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/Exerseaza/google_login');
            $auth_url = $client->createAuthUrl();
            $g_url = filter_var($auth_url, FILTER_SANITIZE_URL);

            $this->load->view('login', ['google_url'=>$g_url]);
        }


        $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

        $this->load->view('widgets/navigation', [
            'categories' => $categories,
            'active_category' => 'home'
        ]);



        $this->load->view('home_body');

        $this->load->view('inc/footer');

    }


}
