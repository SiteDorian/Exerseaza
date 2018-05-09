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
        $this->load->database();
    }

    public $id, $fid, $gid, $name, $email, $password, $status, $created_at, $updated_at=time();

    /**
     * @return mixed
     */
    public function get()
    {
        $query = $this->db->query("select * from users");
            return $query->result();
    }
}