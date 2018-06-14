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


    public function add($name, $price, $description, $category)
    {
        $this->db->select_max('id');
        $this->id = $this->db->get('products')->row()->id + 1;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->id_category = $category;
        $this->created_at = date("Y-m-d h:i:sa");
        $this->updated_at = date("Y-m-d h:i:sa");
        $this->db->insert('products', $this);
        return $this->db->affected_rows();
    }

    public function modify($id, $name, $price, $description, $category)
    {
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'id_category' => $category,
            'updated_at' => date("Y-m-d h:i:sa")
        ];

        $this->db->update('products', $data, array('id' => $id));

        return $this->db->affected_rows();
    }

    public function drop()
    {
        $this->db->delete('products', array('id' => $_POST['id']));
        return;
    }


    public function get($category = '#', $sort = null)
    {
        $conn = "select products.id, products.name, products.price, products.description, products.created_at, products.updated_at, categories.name as category from products
		                                inner join categories on categories.id= products.id_category
										where categories.name like '" . $category . "%' " . $sort;
        $query = $this->db->query($conn);

        return $query->result_array();
    }

    public function getProduct($id)
    {
        $product = $this->db->select('*')->from('products')->where('id', $id)->get()->row();
        if ($this->db->affected_rows() !== 1) {
            return false;
        }
        if ($product) {
            return $product;
        }

        return false;
    }

    public function get_new_products()
    {
        $this->db->order_by("created_at", "desc");
        $this->db->limit(4);
        return $this->db->get('products')->result();
    }

    public function getAll()
    {
        $conn = <<<EOD
select products.id, products.name,  products.price, SUBSTRING(products.description, 1, 20) as description, products.created_at, products.updated_at, categories.name as category from products
	inner join categories on categories.id= products.id_category
		order by id
EOD;
        return $this->db->query($conn)->result();
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