<?php

namespace model;

class UsernameModel {
    private static $USERNAME_SESSION_NAME = 'username';
    private static $name = '';

    public function __construct() {
        if (isset($_SESSION[self::$USERNAME_SESSION_NAME])) {
            self::$name = $_SESSION[self::$USERNAME_SESSION_NAME];
        }
    }

    public function setUsernameUsedInCredentials(string $enteredUsername) {
        $_SESSION[self::$USERNAME_SESSION_NAME] = $enteredUsername;
        self::$name = $_SESSION[self::$USERNAME_SESSION_NAME];
    }

    public function getUsernameUsedInCredentials() : string {
        return self::$name;
    }

    public function removeStoredUsername() {
        self::$name = '';
    }
}
