<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('model/UserDatabase.php');
require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('model/DAL.php');


class RegisterController {

  public function __construct(\model\FlashModel $flashModel, \model\SessionModel $sessionModel) {
      $db = new \model\DAL();
      $this->rw = new \view\RegisterView();
      $this->sm = $sessionModel;
      $this->fm = $flashModel;

      try {

          $this->rw->checkRegisterUsername();
          $this->rw->checkRegisterPassword();
          $this->rw->passwordsMatch();

          if ($this->rw->isRegistering() && $db->compareUsername($this->rw->getUsernameForRegister())) {
              $this->rw->setRegisterExistsMessage();
          } else if ($this->rw->isRegistering()) {
              if ($this->rw->registerSuccessfull()) {
                  $db->addUserToDB($this->rw->getUsernameForRegister(), $this->rw->getPasswordForRegister());
                  $this->fm->setFlashMessage('Registered new user.');
                  header('Location: /');
                  exit();
              }
          }

      } catch (\Exception $e) {
          $_SESSION['message'] = $e->getMessage();
      } finally {
          $this->rw->registerToLayoutView($this->fm, $this->sm);
      }

  }

}
