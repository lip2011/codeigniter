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

        $this->load->helper("array");
        random_element() . "<br>";
        helperTest() . "<br>";

        $this->load->helper("test");
        //testHelperFunction();

        $data["users"] = $this->test_model->getHintUsers($uid);
        $data["content"] = "Hello World";

        //log_message("error", "this is a log test");
        //缓存页面
        //$this->output->cache(30/60);
        $this->load->view($this->folderName . 'header.html');
        #$this->load->view($this->folderName . 'header.html', "", true);
        $this->load->view($this->folderName . 'test.html', $data);
        $this->load->view($this->folderName . 'footer.html');

        $this->output->enable_profiler(false);

        //calendar
        $this->load->library("calendar");
        echo $this->calendar->generate();

        echo "site_url==" . $this->config->site_url() . "<br>";
        echo "base_url==" . $this->config->base_url() . "<br>";
        echo "system_url==" . $this->config->system_url() . "<br><br>";
        echo "APPPATH====" . APPPATH . "<br>";
        echo "BASEPATH====" . BASEPATH . "<br>";
        echo "SYSDIR====" . SYSDIR . "<br>";

    }

    public function smartyTest()
    {
        $this->smarty->assign("notice", "thanks to use Smarty");
        $this->smarty->display("test/smartyTest.html");
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

    public function autoUpload()
    {
        $this->load->helper(array("form", "url"));

        if ($this->input->post("uploadSubmit")) {
            // $config['upload_path'] = APPPATH . 'third_party/upload';
            // $config['allowed_types'] = 'gif|jpg|png';
            // $config['remove_spaces'] = true;
            // $this->load->library("upload", $config);

            /* 还可以参看application/config/file_upload.php  */
            $this->load->library("upload");

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                $this->viewPage("autoUpload.html", $error);
            }
            else {
                $data = array('upload_data' => $this->upload->data());
                $this->viewPage("autoUpload.html", $data);
            }

            return;
        }

        $this->viewPage("autoUpload.html");
    }
}
