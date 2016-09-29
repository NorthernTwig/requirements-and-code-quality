<?php

namespace controller;

require_once("LoginController.php");
require_once("RegisterController.php");
require_once("model/FlashModel.php");
require_once("model/SessionModel.php");

class RoutingController {

  public function __construct() {
    $this->sm = new \model\SessionModel();
    $this->fm = new \model\FlashModel();

    $_SESSION['message'] = '';

    $isRegisterView = isset($_GET['register']);

    switch ($isRegisterView) {
      case false:
        new LoginController($this->fm, $this->sm);
        break;
      case true:
        new RegisterController($this->fm, $this->sm);
        break;
    }
  }
}
