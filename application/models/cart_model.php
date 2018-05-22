<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dorian Gotonoaga
 */
class Cart_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }


    public function getCart($userID)
    {
        $cmd=<<<EOD
      select products.id as id_product, products.name, products.price, cart_items.count, cart_items.href from products
        inner join cart_items on products.id=cart_items.id_product
            inner join cart on cart.id=cart_items.id_cart
                inner join users on users.id=cart.id_user
                where (cart.status=true) and (users.id=$userID)
EOD;

        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    public function updateCart()
    {

    }

    public function updateCartItem()
    {

    }

    public function closeCart($id)
    {
        return;
    }


}