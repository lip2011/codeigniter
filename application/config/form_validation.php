<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $config = array(
                        array(
                                "field" => "email",
                                "label" => "Email Value",
                                "rules" => "trim|callback_username_check|required|valid_email|is_unique[hint_users.email]"
                            ),
                        array(
                                "field" => "password",
                                "label" => "Password Value",
                                "rules" => "trim|required|min_length[4]|max_length[8]|matches[password_again]"
                            ),
                        array(
                                "field" => "password_again",
                                "label" => "Password Again Value",
                                "rules" => "trim|required|min_length[4]|max_length[8]"
                            ),
                        array(
                                "field" => "mycheck[]",
                                "label" => "mycheck Value",
                                "rules" => "required"
                            ),
                        array(
                                "field" => "myradio",
                                "rules" => "required"
                            ),
                    );
