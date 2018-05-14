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
        //$this->load->database();
    }

    public $id, $name, $price, $description, $id_category, $created_at, $updated_at;

    public function add()
    {
        $this->name = $_POST['name'];
        $this->price = $_POST['price'];
        $this->description = $_POST['description'];
        $this->id_category = $_POST['id_category'];
        $this->created_at = time();
        $this->updated_at = time();
    }

    public function modify()
    {
        $this->name = $_POST['name'];
        $this->price = $_POST['price'];
        $this->description = $_POST['description'];
        $this->id_category = $_POST['id_category'];
        $this->updated_at = time();
        $this->db->update('products', $this, array('id' => $_POST['id']));
    }

    public function drop()
    {
        $this->db->delete('products', array('id' => $_POST['id']));
    }


    public function get($category = '#', $sort = null)
    {
        $conn = "select products.id, products.name, products.price, products.description, products.created_at, products.updated_at, categories.name as category from products
		                                inner join categories on categories.id= products.id_category
										where categories.name like '" . $category . "%' " . $sort;
        $query = $this->db->query($conn);

        return $query->result_array();

    }

    public function getRating()
    {
        $conn = "select products.id, round(avg(reviews.rating)) from products
left outer join reviews on products.id=reviews.id_product
group by products.id order by products.id";
        $query = $this->db->query($conn);

        return $query->result_array();
    }
}