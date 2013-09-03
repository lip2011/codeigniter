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
        $userList = $this->db->order_by('id', 'desc')->limit($this->_pageSize, $start)->get('users')->result_array();

        $maxPage = ceil($userCount / $this->_pageSize);
        // $pager = array( 'pageIndex' => $page,
        //                 'requestUrl' => 'user/index',
        //                 'maxPage' => $maxPage,
        //                 'pageParam' => '&type=' . $type);

        $showPageDiv = false;
        $havePrePage = false;
        $prePage = null;
        $haveNextPage = false;
        $nextPage = null;
        if ($maxPage > 1) {
            $showPageDiv = true;
        }
        if ($page < $maxPage) {
            $haveNextPage = true;
            $nextPage = $page + 1;
        }
        if ($page > 1) {
            $havePrePage = true;
            $prePage = $page - 1;
        }

        $pageIndexArray = array();
        for ($i = 1; $i <= $maxPage; $i++) {
            $pageIndexArray[$i]['pageIndex'] = $i;
            $pageIndexArray[$i]['isCurrentPage'] = false;
            if ($page == $i) {
                $pageIndexArray[$i]['isCurrentPage'] = true;
            }
        }

        $pager = array( 'page' => $page,
                        'showPageDiv' => $showPageDiv,
                        'havePrePage' => $havePrePage,
                        'prePage' => $prePage,
                        'haveNextPage' => $haveNextPage,
                        'nextPage' => $nextPage,
                        'requestUrl' => 'user/index',
                        'pageIndexArray' => $pageIndexArray);

        $this->load->helper('user');

        $this->smarty->assign('pageIndexArray', $pageIndexArray);
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