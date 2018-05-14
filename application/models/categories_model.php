<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dorian Gotonoaga
 */
class Categories_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }

    public function getAll()
    {

        if (!($categories = $this->db->query('select * from categories order by id'))) {
//            $error = $this->db->error();
            return false;
        }

        return $categories->result_array();
    }

    public function add($name, $id_parent = null)
    {
        if ($name !== null && $name !== "") {

        } else {
            return array('status' => 400, 'message' => 'Invalid name.');
        }
    }
}