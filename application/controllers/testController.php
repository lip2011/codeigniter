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

        $this->load->view($this->folderName . 'header.html');
        #$this->load->view($this->folderName . 'header.html', "", true);
        $this->load->view($this->folderName . 'test.html', $data);
        $this->load->view($this->folderName . 'footer.html');
    }

    public function createNewUser()
    {
        // $this->load->helper("form");
        // $this->load->library("form_validation");

        // $cheakConfig = array(
        //                     array(
        //                             "field" => "email",
        //                             "label" => "Email Value",
        //                             "rules" => "trim|required|valid_email|is_unique[hint_users.email]"
        //                         ),
        //                     array(
        //                             "field" => "password",
        //                             "label" => "Password Value",
        //                             "rules" => "trim|required|min_length[4]|max_length[8]|matches[password_again]"
        //                         ),
        //                     array(
        //                             "field" => "password_again",
        //                             "label" => "Password Again Value",
        //                             "rules" => "trim|required|min_length[4]|max_length[8]"
        //                         )
        //                 );

        // $this->form_validation->set_rules($cheakConfig);
        // // $this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
        // // $this->form_validation->set_rules("password", "Pawword", "trim|required|min_length[4]|max_length[8]");

        // if ($this->form_validation->run() === FALSE) {
        //     $this->viewPage("create.html");
        // }
        // else {
        //     $this->test_model->insertUser();
        //     $this->viewPage("create_success.html");
        // }
        $result = $this->test_model->insertUser();
        if (!$result) {
            $this->viewPage("create.html");
        }
        else {
            $this->viewPage("create_success.html");
        }
    }

    private function viewPage($pageName, $data = null)
    {   
        $this->load->view($this->folderName . 'header.html');
        if ($data) {
            $this->load->view($this->folderName . $pageName, $data);
        }
        else {
            $this->load->view($this->folderName . $pageName);
        }
        $this->load->view($this->folderName . 'footer.html');
    }
}
