<?php

namespace controller;

require_once('view/LoginView.php');
require_once('view/GetFlashMessages.php');
require_once('model/FlashModel.php');
require_once('model/DAL.php');
require_once('model/SessionModel.php');
require_once('view/GetFlashMessages.php');

class LoginController {
  private static $COOKIE_NAME_STRING = 'Username';
  private static $COOKIE_PASSWORD_STRING = 'Password';
  private static $username = '';
  private static $password = '';

  public function __construct(\model\FlashModel $flashModel, \model\SessionModel $sessionModel, \model\UsernameModel $usernameModel) {
    $this->getFlashMessages = new \view\GetFlashMessages();
    $this->usernameModel = $usernameModel;
    $this->lw = new \view\LoginView($this->usernameModel);
    $this->db = new \model\DAL();
    $this->sm = $sessionModel;
    $this->fm = $flashModel;

    try {
      if (isset($_COOKIE[self::$COOKIE_NAME_STRING]) && !$this->lw->isLoggingOut()) {
        self::$username = $_COOKIE[self::$COOKIE_NAME_STRING];
        self::$password = $_COOKIE[self::$COOKIE_PASSWORD_STRING];
        $this->compareEnteredCredentials();
      } else {
        if ($this->lw->isLoggingIn() && !$this->sm->getIsLoggedIn()) {
          $this->setUsername();
          $this->setPassword();
          $this->compareEnteredCredentials();
          $this->storeUserCredentialsInCookie();
        } else if ($this->lw->isLoggingOut() && $this->sm->getIsLoggedIn()) {
          $this->removeUserCredentialsInCookie();
          $this->usernameModel->removeStoredUsername();
          $this->sm->setIsLoggedIn(false);
          $this->fm->setFlashMessage($this->getFlashMessages->setLogoutMessage());
        }
      }

      } catch (\Exception $e) {
         $this->usernameModel->setUsernameUsedInCredentials(self::$username);
        $this->fm->setFlashMessage($e->getMessage());
      } finally {
        $this->lw->loginToLayoutView($this->fm, $this->sm, $this->usernameModel);
        if ($this->lw->isLoggingIn() || $this->lw->isLoggingOut()) {
          header('Location: /');
          exit();
        }
      }
  }

  private function compareEnteredCredentials() {

    if ($this->db->compareCredentials(self::$username, self::$password)) {

      if ($this->lw->isKeepingLogin()) {
          $this->fm->setFlashMessage($this->getFlashMessages->setWelcomeRemember());
        } else if (!$this->sm->getIsLoggedIn() && isset($_COOKIE[self::$COOKIE_NAME_STRING])) {
            $this->fm->setFlashMessage($this->getFlashMessages->setWelcomeCookie());
        } else if (!$this->sm->getIsLoggedIn()) {
            $this->fm->setFlashMessage($this->getFlashMessages->setWelcomeStandard());
        }

        $this->sm->setIsLoggedIn(true);

    } else if (strlen(self::$password) > 0 || strlen(self::$username) > 0) {
            $this->fm->setFlashMessage($this->getFlashMessages->setWrongCredentials());
    }

  }

  private function setUsername() {
      if (isset($_COOKIE[self::$COOKIE_NAME_STRING])) {
          self::$username = $_COOKIE[self::$COOKIE_NAME_STRING];
      } else {
          self::$username = $this->lw->getUsername();
      }
  }

  private function setPassword() {
    if (isset($_COOKIE[self::$COOKIE_PASSWORD_STRING])) {
        self::$password = $_COOKIE[self::$COOKIE_PASSWORD_STRING];
    } else {
        self::$password = $this->lw->getPassword();
    }
  }

  private function storeUserCredentialsInCookie() {
    if ($this->lw->isKeepingLogin()) {
      $this->setUsernameCookie();
      $this->setPasswordCookie();
    }
  }

  private function removeUserCredentialsInCookie() {
    $this->removeUsernameCookie();
    $this->removePasswordCookie();
  }

  private function setUsernameCookie() {
    setcookie(self::$COOKIE_NAME_STRING, self::$username, time()+36000);
  }

  private function setPasswordCookie() {
    setcookie(self::$COOKIE_PASSWORD_STRING, self::$password, time()+36000);
  }

  private function removeUsernameCookie() {
    setcookie(self::$COOKIE_NAME_STRING, NULL, time()-1);
  }

  private function removePasswordCookie() {
    setcookie(self::$COOKIE_PASSWORD_STRING, NULL, time()-1);
  }

}
