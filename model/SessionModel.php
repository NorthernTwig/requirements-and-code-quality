<?php

namespace model;

class SessionModel {
    private static $LOGIN_SESSION_NAME = 'isLoggedIn';
    private static $isLoggedIn = false;

    public function __construct() {
        if (isset($_SESSION[self::$LOGIN_SESSION_NAME])) {
            self::$isLoggedIn = $_SESSION[self::$LOGIN_SESSION_NAME];
        }
    }

    public function setIsLoggedIn(bool $loggedIn) {
        $_SESSION[self::$LOGIN_SESSION_NAME] = $loggedIn;
        self::$isLoggedIn = $_SESSION[self::$LOGIN_SESSION_NAME];
    }

    public function getIsLoggedIn() : bool {
        return self::$isLoggedIn;
    }

}
