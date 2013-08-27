<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller
{   
    private $_pageSize = 4;

    public function index()
    {
        $type = $this->getParam('type', 1);
        $page = $this->getParam('page', 1);
        $start = ($page - 1) * $this->_pageSize;

        $userCount = $this->db->count_all('users');
        $userList = $this->db->get('users', $this->_pageSize, $start)->result_array();

        $pager = array( 'pageIndex' => $page,
                        'requestUrl' => 'user/index',
                        'maxPager' => ceil($userCount / $this->_pageSize),
                        'pageParam' => '&type=' . $type);


        $this->load->helper('user');

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
}