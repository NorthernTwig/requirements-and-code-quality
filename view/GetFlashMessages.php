<?php

namespace view;

require_once('model/FlashModel.php');

class GetFlashMessages {

  public function __construct($flashModel) {
    $this->FlashModel = $flashModel;
  }

  public function setWelcomeRemember() {
    $this->FlashModel->setFlashMessage('Welcome and you will be remembered');
  }

  public function setWelcomeCookie() {
    $this->FlashModel->setFlashMessage('Welcome back with cookie');
  }

  public function setWelcomeStandard() {
    $this->FlashModel->setFlashMessage('Welcome');
  }

  public function setWrongCredentials() {
    $this->FlashModel->setFlashMessage('Wrong name or password');
  }

  public function setLogoutMessage() {
    $this->FlashModel->setFlashMessage('Bye bye!');
  }

}
