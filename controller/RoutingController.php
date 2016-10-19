<?php

namespace controller;

require_once("LoginController.php");
require_once("RegisterController.php");

class RoutingController {

    private $isRegisterView;

    public function __construct() {
        $this->isRegisterView = isset($_GET['register']);
        $this->route();
    }
    
    private function route() {
        switch ($this->isRegisterView) {
            case false:
                new LoginController();
                break;
            case true:
                new RegisterController();
                break;
        }
    }
}
