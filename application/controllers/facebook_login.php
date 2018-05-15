<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook_login extends CI_Controller
{

    /**
     * Dorian Gotonoaga
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function fb_callback()
    {
        $fb = new Facebook\Facebook([
            'app_id' => '{app-id}', // Replace {app-id} with your app id
            'app_secret' => '{app-secret}',
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

    }

}