<?php

namespace model;

class FlashModel {
  private static $message = '';

  public function __construct() {
    if (isset($_SESSION['message'])) {
      self::$message = $_SESSION['message'];
    }
  }

  public function setFlashMessage(string $flash) {
    $_SESSION['message'] = $flash;
    self::$message = $_SESSION['message'];
  }

  public function removeFlashMessage() {
    self::$message = '';
  }

  public function getFlashMessage() {
    return self::$message;
  }

}
