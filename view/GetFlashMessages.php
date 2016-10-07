<?php

namespace view;

require_once('model/FlashModel.php');

class GetFlashMessages {

  public function setWelcomeRemember() : string {
    return 'Welcome and you will be remembered';
  }

  public function setWelcomeCookie() : string {
    return 'Welcome back with cookie';
  }

  public function setWelcomeStandard() : string {
    return 'Welcome';
  }

  public function setWrongCredentials() : string {
    return 'Wrong name or password';
  }

  public function setLogoutMessage() : string {
    return 'Bye bye!';
  }

}
