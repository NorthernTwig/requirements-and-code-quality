<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('model/UserDatabase.php');
require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('model/DAL.php');


class RegisterController {

  public function __construct($flashModel, $sessionModel) {
    $db = new \model\DAL();
    $this->rw = new \view\RegisterView();
    $this->sm = $sessionModel;
    $this->fm = $flashModel;

    try {
      $this->rw->checkRegisterUsername();
      $this->rw->checkRegisterPassword();
      $this->rw->passwordsMatch();
      if ($db->compareUsername($this->rw->getUsernameForRegister())) {
        $this->rw->setRegisterExistsMessage();
      } else if (strlen($this->rw->getMessage()) <= 0) {
        $db->addUserToDB($this->rw->getUsernameForRegister(), $this->rw->getPasswordForRegister());
      }
    } catch (\Exception $e) {
      $_SESSION['message'] = $e->getMessage();
    } finally {
      $this->rw->registerToLayoutView($this->fm, $this->sm);
    }

  }

}
