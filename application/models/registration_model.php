<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    protected $messages;

    /**
     * error message (uses lang file)
     *
     * @var string
     */
    protected $errors;

    /**
     * error start delimiter
     *
     * @var string
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('email');
        // initialize messages and error
        $this->messages = array();
        $this->errors = array();
    }

    public function register($user, $group = null)
    {
        $email = $user['email'];
        $name = $user['username'];
        $password = $user['password'];
//        $passconf = $user['passconf'];

        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => md5($password),
            'status' => true,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        );

        $this->db->insert('users', $data);

        if (!$this->db->affected_rows()) {
            $this->set_error('Error- the user has not been registered');
            return false;
        }

        return $this->add_to_group($email, $group);

    }

    public function facebookRegister($user)
    {
        $data = array(
            'fid' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => true,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        );

        $this->db->insert('users', $data);

        if (!$this->db->affected_rows()) {
            return false;
        }

        return $this->add_to_group($data['email']);
    }

    public function googleRegister($user)
    {
        $data = array(
            'gid' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => true,
            'created_at' => date("Y-m-d h:i:sa"),
            'updated_at' => date("Y-m-d h:i:sa")
        );

        $this->db->insert('users', $data);

        if (!$this->db->affected_rows()) {
            return false;
        }

        return $this->add_to_group($data['email']);
    }

    public function add_to_group($email, $group = null)
    {
        if (is_null($group)) {
            $group = 2;
        } //default group -> members, id -> 2;

        if ($group == '#') {
            $group = 2;
        }

        $query = $this->db->select('id')
            ->where('email', $email)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get('users');

        $userID = $query->row()->id;

        if ($query->num_rows() !== 1) {
            return false;
        }

        $this->db->insert('users_groups', ['id_user' => $userID, 'id_group' => $group]);

        return true;
    }

    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }

    /**
     * errors
     *
     * Get the error message
     *
     * @return string
     * @author Ben Edmunds
     */
    public function errors()
    {
        $_output = '';
        foreach ($this->errors as $error) {
            $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
            $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
        }

        return $_output;
    }
}