<?php

namespace controller;

require_once("model/FlashModel.php");
require_once("model/SessionModel.php");
require_once("model/UsernameModel.php");

class BaseController {

    public function __construct() {
        $this->sessionModel = new \model\SessionModel();
        $this->flashModel = new \model\FlashModel();
        $this->usernameModel = new \model\UsernameModel();
        $this->db = new \model\DAL();
    }
}
