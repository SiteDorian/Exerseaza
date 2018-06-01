<?php

class Form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_model');
        $this->load->model('users_model');
        //$this->load->library('recaptcha');
    }

    public function index()
    {

    }

    public function ajaxRegistration()
    {


        echo json_encode([
            'html' => 'erroare 112 registration',
            'success' => 1
        ]);

        return;


    }

    public function ajaxLogin()
    {


        $this->form_validation->set_rules('email_login', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'html' => validation_errors(),
                'success' => 1
            ]);
            return;

        }


        echo json_encode([
            'html' => 'succes login',
            'success' => 1
        ]);


    }

    public function registration()
    {
        /**
         * Sample PHP code to use reCAPTCHA V2.
         *
         * @copyright Copyright (c) 2014, Google Inc.
         * @link      http://www.google.com/recaptcha
         *
         * Permission is hereby granted, free of charge, to any person obtaining a copy
         * of this software and associated documentation files (the "Software"), to deal
         * in the Software without restriction, including without limitation the rights
         * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
         * copies of the Software, and to permit persons to whom the Software is
         * furnished to do so, subject to the following conditions:
         *
         * The above copyright notice and this permission notice shall be included in
         * all copies or substantial portions of the Software.
         *
         * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
         * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
         * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
         * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
         * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
         * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
         * THE SOFTWARE.
         */

        //require_once "recaptchalib.php";
        $this->load->library('recaptcha');

// Register API keys at https://www.google.com/recaptcha/admin
        $siteKey = "6LfAh1wUAAAAANXaxmZkSCkBY1mhEJoXU7ybT_TF";
        $secret = "6LfAh1wUAAAAANSWjcuaPXt-7gg95iUGH8Cm1GW7";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
        $lang = "en";

// The response from reCAPTCHA
        $resp = null;
// The error code from reCAPTCHA, if any
        $error = null;

        $reCaptcha = new ReCaptcha($secret);

// Was there a reCAPTCHA response?
        if ($_POST["g-recaptcha-response"]) {
            $resp = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }

        if ($resp != null && $resp->success) {
            //echo "You got it!";
            $data['recaptcha_errors']=$resp;
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');


        if ($this->form_validation->run() == false) {

            $data['register_errors'] = validation_errors();

            $this->load->view('inc/header');

            $this->load->view('login', $data);


            $categories = $this->categories_model->getAll();

            /*echo json_encode([
                'success' => 0,
                'error' => [
                    'login' => 'error message',
                    'password' => 'error message'
                ]
            ]);
            return;
            */

//        $categories['active']='home'; //indica meniul activ

            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'home'
            ]);

            $this->load->view('home_body');

            $this->load->view('inc/footer');

            return;
        }
        $user = $this->users_model->getByEmail($_POST['email']);

        if (!$user) {
            $registrer = $this->registration_model->register($_POST);
            if ($registrer == 0) {
                $this->load->view('formsuccess');
            } else {
                $data['login_errors'] = "Successfull register. <br> Please login...";
                $this->load->view('inc/header');

                $this->load->view('login', $data);


                $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

                $this->load->view('widgets/navigation', [
                    'categories' => $categories,
                    'active_category' => 'home'
                ]);

                $this->load->view('home_body');

                $this->load->view('inc/footer');

                return false;
            }
        } else {
            $data['register_errors'] = "This email already exist.";
            $this->load->view('inc/header');

            $this->load->view('login', $data);


            $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'home'
            ]);

            $this->load->view('home_body');

            $this->load->view('inc/footer');

            return false;
        }


    }

    public function login()
    {
        $this->form_validation->set_rules('email_login', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');


        if ($this->form_validation->run() == false) {
            $data['login_errors'] = validation_errors();
            $this->load->view('inc/header');

            $this->load->view('login', $data);


            $categories = $this->categories_model->getAll();

//        $categories['active']='home'; //indica meniul activ

            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'home'
            ]);

            $this->load->view('home_body');

            $this->load->view('inc/footer');

            return;
        }

        $user = $this->users_model->getByEmail($_POST['email_login']);
        if ($user) {
            if ($user->password == md5($_POST['password'])) {
                $data = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'validated' => true
                );
                $this->session->set_userdata($data);

                redirect('welcome');

                return;
            } else {
                $data['login_errors'] = "Incorrect password.";
                $this->load->view('inc/header');

                $this->load->view('login', $data);


                $categories = $this->categories_model->getAll();


                $this->load->view('widgets/navigation', [
                    'categories' => $categories,
                    'active_category' => 'home'
                ]);

                $this->load->view('home_body');

                $this->load->view('inc/footer');

                return false;
            }
        } else {
            $data['login_errors'] = "Incorrect email.";
            $this->load->view('inc/header');

            $this->load->view('login', $data);


            $categories = $this->categories_model->getAll();


            $this->load->view('widgets/navigation', [
                'categories' => $categories,
                'active_category' => 'home'
            ]);

            $this->load->view('home_body');

            $this->load->view('inc/footer');

            return false;
        }


    }

    public function logout()
    {
        // Remove local Facebook session
        $this->facebook->destroy_session();
        // Remove user data from session
        $array_items = array('id', 'name', 'email', 'validated');
        $this->session->unset_userdata($array_items);
        // Redirect to login page
        redirect('/welcome');
    }
}