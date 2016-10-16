<?php

    namespace controller;

    require_once("LoginController.php");
    require_once("RegisterController.php");
    require_once("model/FlashModel.php");
    require_once("model/SessionModel.php");
    require_once("model/UsernameModel.php");

    class RoutingController {

        public function __construct() {
            $this->sm = new \model\SessionModel();
            $this->fm = new \model\FlashModel();
            $this->um = new \model\UsernameModel();

            $this->isRegisterView = isset($_GET['register']);

            $this->route();

            $this->fm->setFlashMessage('');

        }

        private function route() {
            switch ($this->isRegisterView) {
                case false:
                    $this->createLogin();
                    break;
                case true:
                    $this->createRegister();
                    break;
            }
        }

        private function createLogin() {
            new LoginController($this->fm, $this->sm, $this->um);
        }

        private function createRegister() {
            new RegisterController($this->fm, $this->sm, $this->um);
        }

}
