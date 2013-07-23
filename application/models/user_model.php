<?php

class User_model extends Base_db
{
    public function regist($email, $password)
    {
        return $this->insert('users', array('email' => $email, 'password' => $password));
    }
}
