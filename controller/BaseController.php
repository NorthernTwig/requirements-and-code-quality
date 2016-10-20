<?php

namespace controller;

require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('model/UsernameModel.php');
require_once('model/DAL.php');

abstract class BaseController {

    protected $dal;
    protected $usernameModel;
    protected $sessionModel;
    protected $flashmodel;

    public function __construct() {
        $this->sessionModel = new \model\SessionModel();
        $this->flashModel = new \model\FlashModel();
        $this->usernameModel = new \model\UsernameModel();
        $this->dal = new \model\DAL();
    }
}
