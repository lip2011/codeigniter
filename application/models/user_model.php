<?php

class User_model extends Base_db
{
    public function regist($email, $password)
    {
        return $this->insert('users', array('email' => $email, 'password' => $password));
    }

    public function getUserInfoByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->fetchRow($sql, array('email' => $email));
    }

    public function getUserList()
    {
        return $this->getTableAll('users');
    }
}