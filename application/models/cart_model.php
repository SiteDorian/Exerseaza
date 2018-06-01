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
        $cmd = <<<EOD
      select products.id as add, products.name as w3ls_item, products.price as amount, cart_items.count as quantity, cart_items.href as href from products
        inner join cart_items on products.id=cart_items.id_product
            inner join cart on cart.id=cart_items.id_cart
                inner join users on users.id=cart.id_user
                where (cart.status=true) and (users.id=$userID)
EOD;

        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    public function getCheckout($userID)
    {
        $cmd = <<<EOD
      select products.id, products.name, products.description, products.price, cart_items.count, cart_items.href from products
        inner join cart_items on products.id=cart_items.id_product
            inner join cart on cart.id=cart_items.id_cart
                inner join users on users.id=cart.id_user
                where (cart.status=true) and (users.id=$userID)
EOD;

        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    public function createCart($userID)
    {
        $this->db->where('id_user', $userID);
        $this->db->update('cart', ['status' => false]);

        $this->db->insert('cart', ['id_user' => $userID, 'status' => true]);

        $query = $this->db->get_where('cart', array('id_user' => $userID, 'status' => true))->row();

        return $query->id || null;
    }

    public function updateCart($data)
    {
        if (!$this->session->userdata()) {
            return false;
        }
        $user_data = $this->session->userdata();
        $userID = $user_data['id'];

        //todo Update database

        if (!$userID) {
            return false;
        }

        $this->db->select('id');
        $this->db->from('cart');
        $this->db->where("id_user=$userID");
        $this->db->where("status=true");
        $cartID = $this->db->get()->row();
        if ($cartID) {
            $cartID = $cartID->id;
        } else {
            $cartID = $this->createCart($userID);
        }

        $this->db->where('id_cart', $cartID)->delete('cart_items');

        $product=[];


        foreach ($data as $key => $value) {
            $product = [
                'id_cart' => $cartID,
                'id_product' => $value['add'],
                'price' => $value['amount'],
                'count' => $value['quantity'],
                'href' => $value['href']
            ];
            $this->db->insert('cart_items', $product);
        }

        return true;
    }

    public function updateItem($product)
    {
        if (!$this->session->userdata()) {
            return false;
        }
        $user_data = $this->session->userdata();
        $userID = $user_data['id'];


        if (!$userID) {
            return false;
        }

        $this->db->select('id');
        $this->db->from('cart');
        $this->db->where("id_user=$userID");
        $this->db->where("status=true");
        $cartID = $this->db->get()->row();
        if ($cartID) {
            $cartID = $cartID->id;
        } else {
            $cartID = $this->createCart($userID);
        }

        $pr = [
            'price' => $product['amount'],
            'count' => $product['quantity'],
            'href' => $product['href']
        ];

        $wh = ['id_cart' => $cartID, 'id_product' => $product['add']];

        $this->db->where($wh);
        $this->db->update('cart_items', $pr);

        return $this->db->affected_rows() || false;
    }

    public function addItem($value)
    {
        if (!$this->session->userdata()) {
            return false;
        }
        $user_data = $this->session->userdata();
        $userID = $user_data['id'];


        if (!$userID) {
            return false;
        }

        $this->db->select('id');
        $this->db->from('cart');
        $this->db->where("id_user=$userID");
        $this->db->where("status=true");
        $cartID = $this->db->get()->row();
        if ($cartID) {
            $cartID = $cartID->id;
        } else {
            $cartID = $this->createCart($userID);
        }

        $pr = [
            'id_cart' => $cartID,
            'id_product' => $value['add'],
            'price' => $value['amount'],
            'count' => $value['quantity'],
            'href' => $value['href']
        ];
        $this->db->insert('cart_items', $pr);

        return $this->db->affected_rows();
    }

    public function removeItem($id=null)
    {
        if (!$this->session->userdata()) {
            return false;
        }
        $user_data = $this->session->userdata();
        $userID = $user_data['id'];


        if (!$userID) {
            return false;
        }

        $this->db->select('id');
        $this->db->from('cart');
        $this->db->where("id_user=$userID");
        $this->db->where("status=true");
        $cartID = $this->db->get()->row();
        if ($cartID) {
            $cartID = $cartID->id;
        } else {
            $cartID = $this->createCart($userID);
        }

        $this->db->where(['id_cart' => $cartID, 'id_product' => $id])->delete('cart_items');

        return $this->db->affected_rows();
    }


    //inchiderea cosului dupa trimiterea to orders, dupa ce achita comanda ...
    public function closeCart($id)
    {
        if (!$this->session->userdata()) {
            return false;
        }
        $user_data = $this->session->userdata();
        $userID = $user_data['id'];

        //todo Update database

        if (!$userID) {
            return false;
        }

        $this->db->where('id_user', $userID);
        $this->db->update('cart', ['status' => false]);
        //se vor

        return $this->db->affected_rows();
    }


}