<?php
//require_once 'base_controller.php';

class User extends MY_controller
{
    public function login()
    {

    }

    public function regist()
    {
        $this->smarty->display("user/regist.html");
    }


    public function registCommit()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if($email && $password) {
            $this->load->model('user_model');
            $result = $this->user_model->regist($email, $password);
            if($result) {
                redirect('user/home');
            }
            else {
                redirect('user/regist');
            }
        }
    }

    //返回false表示验证不通过
    public function ajaxCheckEmail()
    {
        $email = $this->input->post('email');

        $this->load->model('user_model');
        $userInfo = $this->user_model->getUserInfoByEmail($email);
        
        echo json_encode(empty($userInfo));
    }

    public function ajaxCheckPhone()
    {
        $phone = $this->input->post('phone');
        echo json_encode(($phone == '021-1234567'));
    }

    public function ajaxGetUserList()
    {
        $this->load->model('user_model');
        $result = $this->user_model->getUserList();
        echo json_encode($result);
    }

    public function home()
    {
        $this->smarty->display("user/home.html");
    }
}