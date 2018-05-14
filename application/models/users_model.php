<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dorian Gotonoaga
 */
class Users_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }

    public $id, $fid, $gid, $name, $email, $password, $status, $created_at, $updated_at = time();

    /**
     * @return mixed
     */
    public function getAll()
    {
        $query = $this->db->query("select * from users");
        return $query->result();
    }

    public function getByEmail($email)
    {
        $query = $this->db->query("select * from users where email like '$email'");
        return $query->result();
    }

    public function get($id)
    {
        $query = $this->db->query("select * from users where id=$id");

        return $query->result();
    }

    public function update()
    {
        //todo
    }


}