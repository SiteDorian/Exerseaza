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
        //$this->load->database();
    }

    public $id, $fid, $gid, $name, $email, $password, $status, $created_at, $updated_at;

    /**
     * @return mixed
     */
    public function getAll()
    {
        $query = $this->db->query("select * from users");
        return $query->result();
    }

    public function getByEmail($email)
    {
        //$query = $this->db->query("select * from users where email like '$email'")->get()->row();
        $rez = $this->db->select('*')->from('users')->where('email', $email)->get()->row();
        return $rez;
    }

    public function get($id)
    {
        $query = $this->db->query("select * from users where id=$id");

        return $query->result();
    }

    public function update($user)
    {
        $data = array(
            'name' => $user->name,
            'status' => true,
            'updated_at' => date("Y-m-d h:i:sa")
        );
        $this->db->update('users', $data, array('email' => $user->email));

        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        //todo
    }


}