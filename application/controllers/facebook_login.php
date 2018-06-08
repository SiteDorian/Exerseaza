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
        $this->load->library('facebook');
        $this->load->helper('url');
        $this->load->model('registration_model');
        $this->load->model('users_model');
        $this->load->model('groups_model');
    }

    function fblogin(){

        $fb = new Facebook\Facebook([
            'app_id' => '2010380982507690', // Replace {app-id} with your app id
            'app_secret' => '27e1b9dd2661864c2b7a60ea7daf27e1',
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email'];
// For more permissions like user location etc you need to send your application for review

        $loginUrl = $helper->getLoginUrl('http://ff597559.ngrok.io/Exerseaza/facebook_login/fbcallback', $permissions);

        header("location: ".$loginUrl);
    }

    function fbcallback(){

        $fb = new Facebook\Facebook([
            'app_id' => '2010380982507690', // Replace {app-id} with your app id
            'app_secret' => '27e1b9dd2661864c2b7a60ea7daf27e1',
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $_SESSION['FBRLH_state']=$_GET['state'];

        try {

            $accessToken = $helper->getAccessToken("http://ff597559.ngrok.io/Exerseaza/facebook_login/fbcallback");

        }catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            //echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }


        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name,birthday,location,gender', $accessToken);
            // print_r($response);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            //echo 'ERROR: Graph ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            //echo 'ERROR: validation fails ' . $e->getMessage();
            exit;
        }

        // User Information Retrival begins................................................
        $me = $response->getGraphUser();

        $location = $me->getProperty('location');
        echo "Full Name: ".$me->getProperty('name')."<br>";
        echo "First Name: ".$me->getProperty('first_name')."<br>";
        echo "Last Name: ".$me->getProperty('last_name')."<br>";
        echo "Gender: ".$me->getProperty('gender')."<br>";
        echo "Email: ".$me->getProperty('email')."<br>";
        echo "location: ".$location['name']."<br>";
        echo "Birthday: ".$me->getProperty('birthday')->format('d/m/Y')."<br>";
        echo "Facebook ID: <a href='https://www.facebook.com/".$me->getProperty('id')."' target='_blank'>".$me->getProperty('id')."</a>"."<br>";
        $profileid = $me->getProperty('id');
        echo "</br><img src='//graph.facebook.com/$profileid/picture?type=large'> ";
        echo "</br></br>Access Token : </br>".$accessToken;

        $user = $this->users_model->getByEmail($me->getProperty('email'));

        if ($user) {
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

        $registrer = $this->registration_model->facebookRegister($me);

        if ($registrer == 0) {
            redirect('welcome');
            return;
        }

        $user = $this->users_model->getByEmail($me->getProperty('email'));

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

    public function index()
    {
        //require_once 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';

        $fb = new Facebook\Facebook([
            'app_id' => '2010380982507690', // Replace {app-id} with your app id
            'app_secret' => '27e1b9dd2661864c2b7a60ea7daf27e1',
            'default_graph_version' => 'v2.2',
        ]);

        $_SESSION['FBRLH_state']=$_GET['state'];

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

// Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('{app-id}'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');


    }

    public function logout() {
        // Remove local Facebook session
        $this->facebook->destroy_session();
        // Remove user data from session
        $this->session->unset_userdata('userData');
        // Redirect to login page
        redirect('/user_authentication');
    }



}