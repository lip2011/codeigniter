<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller
{   
    private $_pageSize = 4;

    public function index()
    {
        $page = $this->getParam('page', 1);

        $this->load->model('user_model');
        $userList = $this->user_model->getUserList($page);
        $pager = $this->user_model->buildPager($page);

        $this->load->helper('user');

        // $this->smarty->assign('pageIndexArray', $pageIndexArray);
        $this->smarty->assign('userList', $userList);
        $this->smarty->assign('pager', $pager);
        $this->smarty->display('user/index.html');
    }

    public function login()
    {
        $email = $this->getPost('email');
        $password = $this->getPost('password');

        if (!empty($email) && !empty($password)) {
            $this->load->model('user_model');
            $loginResult = $this->user_model->login($email, $password);
            if ($loginResult) {
                //redirect($this->_adminBaseUrl . '/user');
            }
        }

        $this->smarty->display('user/login.html');
    }

    public function create()
    {
        $params = $this->getPost();
        unset($params['password_confirm']);
        echo $this->db->insert('users', $params);
    }

    public function getUserListByPage()
    {
        $page = $this->getPost('page');
        $start = ($page - 1) * $this->_pageSize;

        $userList = $this->db->order_by('id', 'desc')->limit($this->_pageSize, $start)->get('users')->result_array();

        if (!empty($userList)) {
            echo json_encode($userList);
        } else {
            echo false;
        }
    }
}