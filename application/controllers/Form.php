<?php

class Form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_model');
        $this->load->model('users_model');
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