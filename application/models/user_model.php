<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model 
{
    public function login($email, $password)
    {
        $userInfo = $this->db->get_where('users', array('email' => $email))->result_array();

        if (count($userInfo) == 1) {
            return true;
        }

        return false;
    }
} 
