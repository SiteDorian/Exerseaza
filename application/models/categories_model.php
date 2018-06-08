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

    public function get($id = -1)
    {
        if (!($category = $this->db->query("select * from categories where id=$id"))) {
//            $error = $this->db->error();
            return false;
        }

        return $category;
    }

    public function getAll($order = 'id')
    {

        if (!($categories = $this->db->query("select * from categories ORDER BY $order IS NULL DESC, $order asc"))) {
//            $error = $this->db->error();
            return false;
        }

        return $categories->result_array();
    }

    public function add($name, $id_parent = null)
    {
        if ($name !== null && $name !== "" && strlen($name) >= 2 && (is_numeric($id_parent) || is_null($id_parent))) {
            $this->db->select_max('id');
            $id = $this->db->get('categories')->row()->id;
            $data = ['id'=> ((int) $id+1) ,'name' => $name, 'id_parent' => $id_parent];
            $this->db->insert('categories', $data);
            return $this->db->affected_rows();

        } else {
            return false;
        }
    }

    public function update($id, $data=[])
    {
        if ($this->db->update('categories', $data, ['id' => $id])) {
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}