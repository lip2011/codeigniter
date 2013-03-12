<?php

class TestController extends CI_Controller {

    private $folderName = "test/";

    public function __construct()
    {
        parent::__construct();
        $this->load->model("test_model");
    }

    public function index($uid = null)
    {

        $data["users"] = $this->test_model->getHintUsers($uid);
        $data["content"] = "Hello World";
//print_r("user===" . json_encode($data["users"]));
        $this->load->view($this->folderName . 'header.html');
        $this->load->view($this->folderName . 'test.html', $data);
        $this->load->view($this->folderName . 'footer.html');
    }
}
