<?php
//require_once 'base_controller.php';

class User extends MY_controller
{
    public function login()
    {

    }

    public function register()
    {
        $this->smarty->display("user/register.html");
    }
}


?>