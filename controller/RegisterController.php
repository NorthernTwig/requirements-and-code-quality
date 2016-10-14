<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('model/DAL.php');


class RegisterController {

  public function __construct(\model\FlashModel $flashModel, \model\SessionModel $sessionModel, \model\UsernameModel $usernameModel) {
      $this->getFlashMessages = new \view\GetFlashMessages();
      $this->usernameModel = $usernameModel;
      $db = new \model\DAL();
      $this->rw = new \view\RegisterView();
      $this->sm = $sessionModel;
      $this->fm = $flashModel;

      $this->rw->checkRegisterUsername();
      $this->rw->checkRegisterPassword();
      $this->rw->passwordsMatch();

      try {

          if (strlen($this->rw->getUsernameForRegister()) > 0 && $this->rw->isRegistering() && $db->compareUsername($this->rw->getUsernameForRegister())) {
              $this->rw->setRegisterExistsMessage();
          } else if ($this->rw->isRegistering()) {
              if ($this->rw->registerSuccessfull()) {
                  $db->addUserToDB($this->rw->getUsernameForRegister(), $this->rw->getPasswordForRegister());
                  $this->fm->setFlashMessage($this->getFlashMessages->setNewRegisterMessage());
                  header('Location: /');
                  exit();
              }
          }

      } catch (\Exception $e) {
          $this->fm->setFlashMessage($e->getMessage());
      } finally {
          $this->rw->registerToLayoutView($this->fm, $this->sm);
      }

  }

}
