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

    public function get($category = null)
    {
        $conn = "select images.id_product as id, images.ordin, images.is_main, images.img_link as img from images 
	              inner join products on products.id=images.id_product
		            inner join categories on categories.id=products.id_category 
		              where categories.name like '" . $category . "' order by images.is_main desc";

        $query = $this->db->query($conn);

        return $query->result_array();
    }

    public function get_main($category = null)
    {
        $conn = "select products.id, images.img_link from products 
                    inner join images on images.id_product=products.id
                      inner join categories on categories.id=products.id_category 
	                     where (images.is_main=true) and (categories.name like '" . $category . "%') order by id";
        $query = $this->db->query($conn);

        return $query->result_array();
    }

    public function get_main_checkout($userID = "0")
    {
        $conn = <<<EOD
select products.id as id_product, images.img_link as img from products 
        inner join cart_items on products.id=cart_items.id_product
            inner join cart on cart.id=cart_items.id_cart
                inner join users on users.id=cart.id_user
					inner join images on images.id_product=products.id
                		where (cart.status=true) and (users.id=$userID) and (images.is_main=true);
EOD;
        $query = $this->db->query($conn);

        return $query->result_array();
    }

    public function get_product_images($productID)
    {
        $conn = "select images.id, images.id_product, images.ordin, images.is_main, images.img_link from images where id_product=$productID";

        $query = $this->db->query($conn);

        return $query->result();
    }

    public function upload($productID, $img_link = null, $is_main = false)
    {
        $this->db->insert('images', [
            'id' => $this->get_next_id(),
            'id_product' => $productID,
            'ordin' => null,
            'is_main' => $is_main,
            'img_link' => $img_link
        ]);
//        INSERT INTO images (image_name, image_data)
//VALUES( 'image_one', decode('', 'base64') );
        return $this->db->affected_rows();
    }

    public function get_next_id()
    {
        $this->db->select_max('id');
        $result = $this->db->get('images')->row();
        return (int)$result->id + 1;
    }

    public function delete($id)
    {
        $id = (int) $id;
        $link = $this->db->select('img_link')->from('images')->where('id', $id)->get()->row();
        if ($this->db->affected_rows() !== 1) {
            return false;
        }
        if ($link) {
            $this->db->delete('images', ['id' => $id]);
            if ($this->db->affected_rows() !== 1) {
                return false;
            }
            return $link->img_link;
        }

        return false;
    }

}