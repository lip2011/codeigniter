<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model 
{
    private $_pageSize = 4;

    public function login($email, $password)
    {
        $userInfo = $this->db->get_where('users', array('email' => $email))->result_array();

        if (count($userInfo) == 1) {
            return true;
        }

        return false;
    }

    public function getUserList($page)
    {
        $start = ($page - 1) * $this->_pageSize;

        return $this->db->order_by('id', 'desc')->limit($this->_pageSize, $start)->get('users')->result_array();
    }

    public function buildPager($page)
    {
        $userCount = $this->db->count_all('users');
        $maxPage = ceil($userCount / $this->_pageSize);

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

        return array( 'page' => $page,
                        'showPageDiv' => $showPageDiv,
                        'havePrePage' => $havePrePage,
                        'prePage' => $prePage,
                        'haveNextPage' => $haveNextPage,
                        'nextPage' => $nextPage,
                        'requestUrl' => 'user/index',
                        'pageIndexArray' => $pageIndexArray);

    }
} 
