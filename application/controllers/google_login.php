<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('registration_model');
        $this->load->model('users_model');
        $this->load->model('groups_model');
    }

    public function index()
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secrets.json');
        $client->setAccessType("offline"); // offline access
        $client->setIncludeGrantedScopes(true); // incremental auth
        $client->addScope("profile");
        $client->addScope("email");
        $service = new Google_Service_Oauth2($client);

        if (isset($_SESSION['google_access_token']) && $_SESSION['google_access_token']) {


            $client->setAccessToken($_SESSION['google_access_token']);

            //$oauth = new Google_Service_Oauth2($client);

            $google_oauth = new Google_Service_Oauth2($client);

            $userProfileDetails = $google_oauth->userinfo->get();
            //revoke token to deauthorize the current access token
            $client->revokeToken();
            $_SESSION['google_access_token'] = false;


            //print_r($userProfileDetails);
            if ($userProfileDetails) {
//                echo $userProfileDetails->id . '<br>';
//                echo $userProfileDetails->email . '<br>';
//                echo $userProfileDetails->link . '<br>';
//                echo $userProfileDetails->name . '<br>';
//
//                //show user picture
//                echo '<img src="' . $userProfileDetails->picture . '" style="display: block; width: 100px;" />';

                $user = $this->users_model->getByEmail($userProfileDetails->email);

                if ($user) {
                    $data = array(
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'validated' => true
                    );
                    $this->session->set_userdata($data);

                    $this->users_model->update($user);

                    redirect('welcome');

                    return;
                }

                $registrer = $this->registration_model->googleRegister($userProfileDetails);

                if ($registrer == 0) {
                    redirect('welcome');
                    return;
                }

                $user = $this->users_model->getByEmail($userProfileDetails->email);

                $this->groups_model->add($user->id);

                $data = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'validated' => true
                );
                $this->session->set_userdata($data);

                redirect('welcome');

                return;
            }




        } else {
//            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gmailAPI/oauth2callback.php';
//            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            redirect("google_login/oauth2callback");
        }


    }

    public function oauth2callback()
    {
        $client = new Google_Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->setAccessType("offline"); // offline access
        $client->setIncludeGrantedScopes(true); // incremental auth
        $client->setRedirectUri(  base_url() . 'google_login/oauth2callback');
        $client->setScopes(array('profile', 'email'));

        if (!isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['google_access_token'] = $client->getAccessToken();
//            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gmailAPI/index.php';
//            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            redirect("google_login/index");
        }
    }
}