<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dorian Gotonoaga
 */
class Images_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($category = "#")
    {
        $conn = "select images.id_product as id, encode(images.img, 'base64') as img, images.ordin, images.is_main from images 
	              inner join products on products.id=images.id_product
		            inner join categories on categories.id=products.id_category 
		              where categories.name like '" . $category . "%' order by id";

        $query = $this->db->query($conn);

        return $query->result_array();
    }

    public function get_main($category = "#")
    {
        $conn = "select products.id, encode(images.img, 'base64') as img from products 
                    inner join images on images.id_product=products.id
                      inner join categories on categories.id=products.id_category 
	                     where (images.is_main=true) and (categories.name like '" . $category . "%') order by id";
        $query = $this->db->query($conn);

        return $query->result_array();
    }
}