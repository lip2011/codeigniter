<?php

class MY_Controller extends CI_controller
{
    protected $_adminBaseUrl;
    protected $_adminStaticUrl;
    protected $_staticUrl;

    public function __construct()
    {
        parent::__construct();

        //校验session是否过期
        $this->checkUserSession();

        //权限判断
        $this->checkUserPurview();
        
        //设置语言
        //$this->setLanguage();

        $this->_adminStaticUrl = base_url() . 'static/admin';
        $this->_adminBaseUrl = base_url() . 'admin';
        $this->_staticUrl = base_url() . 'static';

        $this->smarty->assign('staticUrl', $this->_staticUrl);
        $this->smarty->assign('adminBaseUrl', $this->_adminBaseUrl);
        $this->smarty->assign('adminStaticUrl', $this->_adminStaticUrl);
        $this->smarty->assign('local', $this->config->item('language'));
    }

    private function checkUserSession()
    {   

    }

    private function checkUserPurview()
    {

    }

    private function setLanguage()
    {
        $language = $this->config->item('language');
        $local = $this->getParam('local', $language);
        if ($local == 'en') {
            $this->config->set_item('language', 'en');
        }
        if ($local == 'jp') {
            $this->config->set_item('language', 'jp');
        }
    }

    public function getControllerName()
    {
        return $this->uri->segment(2);
    }

    public function getActionName()
    {
        return $this->uri->segment(3, 'index');
    }

    public function getParam($key = null, $defaultValue = null)
    {
        if (null === $key) {
            return $this->input->get(null, true);
        }

        $param = $this->input->get($key, true);
        if (empty($param) && !empty($defaultValue)) {
            return $defaultValue;
        }
        return $param;
    }

    public function getPost($key = null, $defaultValue = null)
    {
        if (null === $key) {
            return $this->input->post(null, true);
        }

        $param = $this->input->post($key, true);
        if (empty($param) && !empty($defaultValue)) {
            return $defaultValue;
        }
        return $param;
    }
}
