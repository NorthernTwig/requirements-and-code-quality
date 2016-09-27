<?php

namespace controller;

require_once("view/RegisterView.php");
require_once("model/UserDatabase.php");
require_once("model/FlashModel.php");
require_once("model/SessionModel.php");

class RegisterController {

  public function __construct($flashModel, $sessionModel) {
    $rv = new \view\RegisterView($sessionModel);
    $this->sm = $sessionModel;
    $this->fm = $flashModel;

  }

}
