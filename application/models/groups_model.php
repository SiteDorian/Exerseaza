<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Groups_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($userID, $groupID = 2)
    {
        $this->db->insert('users_groups', ['id_user' => $userID, 'id_group' => $groupID]);
        return $this->db->affected_rows();
    }

    public function get()
    {
        if ($this->db->get('groups')) {
            return $this->db->get('groups')->result();
        }
        return false;
    }

}