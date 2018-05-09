<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dorian Gotonoaga
 */

    class Products_model extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public $id, $name, $price, $description, $id_category, $created_at, $updated_at;

        public function add()
        {
            $this->name = $_POST['name'];
            $this->price = $_POST['price'];
            $this->description=$_POST['description'];
            $this->id_category=$_POST['id_category'];
            $this->created_at=time();
            $this->updated_at=time();
        }

        public function modify()
        {
            $this->name = $_POST['name'];
            $this->price = $_POST['price'];
            $this->description=$_POST['description'];
            $this->id_category=$_POST['id_category'];
            $this->updated_at=time();
            $this->db->update('products', $this, array('id' => $_POST['id']));
        }

        public function drop()
        {
            $this->db->delete('products', array('id' => $_POST['id']));
        }


        public function get($category='#'){
            $conn="select products.id, products.name, products.price, products.description, products.created_at, products.updated_at, categories.name as category from products
		                                inner join categories on categories.id= products.id_category
										where categories.name like '".$category."%'";
            $query = $this->db->query($conn);
            if ($query)
            {
                return array('status'=>200, 'content'=>$query->result());
            }
            else
            {
                return array('status'=>400, 'message'=>'Not data |or| Bad request.');
            }
        }
    }