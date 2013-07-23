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
    //json名字可以随意,但[0]位置 必须是验证的控件id,[1]位置是是否成功
    $arrayToJs = array();
    $arrayToJs[0] = array();

    $arrayToJs[0][0] = 'inputEmail';
    $arrayToJs[0][1] = 'OK';
    //$arrayToJs[0][2] = "此名称可以使用";
header("Content-type: application/json");
echo json_encode($arrayToJs);




        // $email = $this->input->post('email');
        // $password = $this->input->post('password');

        // if($email && $password) {
        //     $this->load->model('user_model');
        //     $result = $this->user_model->regist($email, $password);
        //     if($result) {
        //         redirect('user/home');
        //     }
        //     else {
        //         redirect('user/regist');
        //     }
        // }
    }

    public function home()
    {
        $this->smarty->display("user/home.html");
    }
}