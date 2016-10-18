<?php

namespace model;

require_once('exceptions/WrongCredentialsException.php');
require_once('exceptions/InvalidSymbolsUsernameException.php');
require_once('exceptions/UsernameTooShortException.php');
require_once('exceptions/PasswordTooShortException.php');
require_once('exceptions/PasswordsDoNotMatchException.php');

class DAL {
    private static $REGISTER_SUCCESS = false;


    public function __construct() {
        $this->jsonString = file_get_contents('./database/UserCredentials.json');
      }

    public function decodeJson() {
        return json_decode($this->jsonString, true);
      }

    public function compareCredentials($enteredUsername, $enteredPassword) {
        $accounts = $this->decodeJson();
        $isCredentialsCorrect = false;

        for ($i = 0; $i < count($accounts); $i++) {
          if ($accounts[$i]['username'] === $enteredUsername && $accounts[$i]['password'] === $enteredPassword) {
            $isCredentialsCorrect = true;
          }
        }

        if (!$isCredentialsCorrect) {
            throw new \WrongCredentialsException('User failed to login');
        }

        return $isCredentialsCorrect;

      }

    public function validatePassword(string $password, string $passwordMatch) {
        if (strlen($password) < 6) {
            throw new \PasswordTooShortException('User entered a password that was too short');
        }

        if ($password !== $passwordMatch) {
            throw new \PasswordsDoNotMatchException('User entered two different passwords.');
        }
    }

    public function validateUsername(string $username) {
          preg_match('/^[a-zA-Z0-9]+$/', $username, $matches);

          if (!(count($matches) > 0)) {
              throw new \InvalidSymbolsUsernameException('User entered username with invalid characters');
          }

          if (strlen($username) < 3) {
              throw new \UsernameTooShortException('User entered a too short username');
          }

    }

    public function stripUsername(string $username) : string {
        $cleanedUsername = strip_tags($username);
        return $cleanedUsername;
    }

    public function compareUsername($enteredUsername) {
        $accounts = $this->decodeJson();
        $usernameExists = false;

        for ($i = 0; $i < count($accounts); $i++) {
          if ($accounts[$i]['username'] === $enteredUsername) {
            $usernameExists = true;
          }
        }
        return $usernameExists;
      }

    public function addUserToDB($enteredUsername, $enteredPassword) {
        $json = $this->decodeJson();
        $newCredArray = array();
        $newCredArray['username'] = $enteredUsername;
        $newCredArray['password'] = $enteredPassword;
        array_push($json, $newCredArray);
        if ($enteredUsername !== NULL || $enteredPassword !== NULL) {
          $this->saveDB($json);
        }
      }

    public function saveDB($newJson) {
        $encodedJson = json_encode($newJson);
        file_put_contents('./database/UserCredentials.json', $encodedJson);
        self::$REGISTER_SUCCESS = true;
      }

    public function wasSuccessfull() {
          return self::$REGISTER_SUCCESS;
      }



}
