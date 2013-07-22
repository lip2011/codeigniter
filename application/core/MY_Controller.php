<?php

class MY_Controller extends CI_controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');

        $this->smarty->assign('baseUrl', base_url());
        $this->smarty->assign('staticUrl', base_url() . 'index.php/application/static');
    }
}
