<?php

namespace controller;

require_once('LoginController.php');
require_once('RegisterController.php');

class RoutingController {

    private $registerController;
    private $loginController;

    public function __construct() {
        $this->registerController = new RegisterController();
        $this->loginController = new LoginController();
        $this->route();
    }

    private function route() {
        switch ($this->registerController->getShouldRenderRegister()) {
            case false:
                $this->loginController->loginInit();
                break;
            case true:
                $this->registerController->registerInit();
                break;
        }
    }
}
