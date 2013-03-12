<?php

class Test_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function getHintUsers($uid = null)
    {
        if ($uid) {
            $query = $this->db->get_where("hint_users", array("id" => $uid));
            return $query->result_array();
        }

        $query = $this->db->get("hint_users");
        return $query->result_array();
    }
} 
