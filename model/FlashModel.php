<?php

namespace model;

class FlashModel {

    private static $MESSAGE_SESSION_NAME = 'message';
    private static $message = '';

    public function __construct() {
        if (isset($_SESSION[self::$MESSAGE_SESSION_NAME])) {
            self::$message = $_SESSION[self::$MESSAGE_SESSION_NAME];
        }
    }

    public function setFlashMessage(string $flash) {
        $_SESSION[self::$MESSAGE_SESSION_NAME] = $flash;
        self::$message = $_SESSION[self::$MESSAGE_SESSION_NAME];
    }

    public function resetMessageFromCredentials() {
        if (isset($_SESSION[self::$MESSAGE_SESSION_NAME])) {
            self::$message = '';
        }
    }

    public function removeFlashMessage() {
        self::$message = '';
    }

    public function getFlashMessage() {
        return self::$message;
    }
}
