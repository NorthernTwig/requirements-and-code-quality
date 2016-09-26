<?php

namespace controller;

require_once("view/LoginView.php");
require_once("model/UserDatabase.php");
require_once("model/FlashModel.php");
require_once("model/SessionModel.php");

class LoginController {

  public function __construct($flashModel, $sessionModel) {
    $this->lw = new \view\LoginView();
    $this->sm = $sessionModel;
    $this->fm = $flashModel;

      try {
        if ($this->lw->isLoggingIn()) {
          $this->username = $this->lw->getUsername();
          $_SESSION['username'] = $this->lw->getUsername();
          $this->password = $this->lw->getPassword();
          $this->compareEnteredCredentials();
        } else if ($this->lw->isLoggingOut() && $this->sm->getIsLoggedIn()) {
          $_SESSION['username'] = '';
          $_SESSION['isLoggedIn'] = false;
          $_SESSION['message'] = 'Bye bye!';
        }
      } catch (\Exception $e) {
        $_SESSION['message'] = $e->getMessage();
      } finally {
        $this->lw->toLayoutView($this->fm, $this->sm);
        if ($this->lw->isLoggingIn() || $this->lw->isLoggingOut()) {
          header('Location: /');
          exit();
        }
      }
  }

  private function getExistingUsers() {
    $udb = new \model\UserDatabase();
    return $udb->superRealDatabase();
  }

  private function compareEnteredCredentials() {

    $existingUsers = $this->getExistingUsers();

    if ($existingUsers['username'] == $this->username && $existingUsers['password'] == $this->password) {
      $_SESSION['isLoggedIn'] = true;
      if ($this->lw->isKeepingLogin()) {
        $_SESSION['message'] = 'Welcome and you will be remembered';
      } else if (!$this->sm->getIsLoggedIn()) {
        $_SESSION['message'] = 'Welcome';
      }
    } else {
      $_SESSION['message'] = 'Wrong name or password';
    }

  }

}
