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

    $this->fm->removeFlashMessage();

    $isRegisterView = isset($_GET['register']);

    switch ($isRegisterView) {
      case false:
        new LoginController($this->fm, $this->sm, $this->um);
        break;
      case true:
        new RegisterController($this->fm, $this->sm, $this->um);
        break;
    }
  }
}
