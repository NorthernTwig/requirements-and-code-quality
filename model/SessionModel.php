<?php

namespace model;

class SessionModel {
  private static $isLoggedIn = false;

  public function __construct() {
    if (isset($_SESSION['isLoggedIn'])) {
      self::$isLoggedIn = $_SESSION['isLoggedIn'];
    }
  }

  public function setIsLoggedIn(bool $loggedIn) {
    $_SESSION['isLoggedIn'] = $loggedIn;
  }

  public function getIsLoggedIn() : bool {
    return self::$isLoggedIn;
  }

}
