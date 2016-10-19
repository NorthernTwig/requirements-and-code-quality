<?php

namespace model;

require_once('exceptions/InvalidSymbolsUsernameException.php');
require_once('exceptions/UsernameTooShortException.php');
require_once('exceptions/NoEnteredCredentialsException.php');
require_once('exceptions/PasswordTooShortException.php');
require_once('exceptions/PasswordsDoNotMatchException.php');

class UserModel {

    private $username;
    private $password;
    private $passwordMatch;

    public function __construct(string $username, string $password, string $passwordMatch) {
        $this->username = $username;
        $this->password = $password;
        $this->passwordMatch = $passwordMatch;
        $this->validateCredentialsExist();
        $this->validateUsername();
        $this->validatePassword();
    }

    private function validateCredentialsExist() {
        if ($this->username === '' || ctype_space($this->username)) {
            if ($this->password === '' || ctype_space($this->password)) {
                throw new \NoEnteredCredentials('User did not enter any login information');
            }
        }
    }

    private function validateUsername() {
        preg_match('/^[a-zA-Z0-9]+$/', $this->username, $matches);

        if (!(count($matches) > 0)) {
            throw new \InvalidSymbolsUsernameException('User entered username with invalid characters');
        }

        if (strlen($this->username) < 3) {
            throw new \UsernameTooShortException('User entered a too short username');
        }

    }

    private function validatePassword() {

        if (strlen($this->password) < 6) {
            throw new \PasswordTooShortException('User entered a password that was too short');
        }

        if ($this->password !== $this->passwordMatch) {
            throw new \PasswordsDoNotMatchException('User entered two different passwords.');
        }
    }
}
