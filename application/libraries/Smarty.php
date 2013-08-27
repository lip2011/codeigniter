<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "third_party/smarty/Smarty.class.php";

//using the CI_ prefix instead of the MY_ prefix but no class called Smarty exists in CodeIgniter
class CI_Smarty extends Smarty
{
    function __construct()
    {
        parent::__construct();

        $this->left_delimiter = "{%";
        $this->right_delimiter = "%}";
        $this->setTemplateDir(APPPATH . "views/admin");
        $this->setCompileDir(APPPATH . "templates_c/admin");
        $this->setPluginsDir(array(APPPATH . "third_party/smarty/plugins", APPPATH . "third_party/smarty/myplugins"));
    }
}