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
            //return $query->row_array();
            return $query->result_array();
        }

        $query = $this->db->get("hint_users");
        return $query->result_array();
    }

    public function insertUser()
    {
        $this->load->helper("form");
        $this->load->library("form_validation");

        $cheakConfig = array(
                            array(
                                    "field" => "email",
                                    "label" => "Email Value",
                                    "rules" => "trim|required|valid_email|is_unique[hint_users.email]"
                                ),
                            array(
                                    "field" => "password",
                                    "label" => "Password Value",
                                    "rules" => "trim|required|min_length[4]|max_length[8]|matches[password_again]"
                                ),
                            array(
                                    "field" => "password_again",
                                    "label" => "Password Again Value",
                                    "rules" => "trim|required|min_length[4]|max_length[8]"
                                )
                        );

        $this->form_validation->set_rules($cheakConfig);
        if ($this->form_validation->run() === FALSE) {
            return false;
        }

        $passwordSalt = "aaaaaa";
        $data = array(
                    "email" => $this->input->post("email"),
                    "password_salt" => $passwordSalt,
                    "encrypted_password" => md5($passwordSalt . $this->input->post("password")),
                    "created_at" => date("Y-m-d H:i:s")
                );

        return $this->db->insert("hint_users", $data);
    }
} 
