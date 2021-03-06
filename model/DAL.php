<?php

namespace model;

require_once('exceptions/WrongCredentialsException.php');
require_once('exceptions/UserAlreadyExistException.php');


class DAL {

    private static $USERNAME_SEARCH_STRING = 'username';
    private static $PASSWORD_SEARCH_STRING = 'password';
    private static $DATABASE_LOCATION = './database/UserCredentials.json';

    private $dbJsonFormat;

    public function __construct() {
        $this->dbJsonFormat = file_get_contents(self::$DATABASE_LOCATION);
    }

    public function decodeJson() {
        return json_decode($this->dbJsonFormat, true);
    }

    public function compareCredentials($enteredUsername, $enteredPassword) {
        $accounts = $this->decodeJson();
        $isCredentialsCorrect = false;


        for ($i = 0; $i < count($accounts); $i++) {
            if ($accounts[$i][self::$USERNAME_SEARCH_STRING] === $enteredUsername && $accounts[$i][self::$PASSWORD_SEARCH_STRING] === $enteredPassword) {
                $isCredentialsCorrect = true;
            }
        }

        if (!$isCredentialsCorrect) {
            throw new \WrongCredentialsException('User failed to login');
        }

        return $isCredentialsCorrect;
    }

    public function compareUsernameWithDatabase($enteredUsername) {
        $accounts = $this->decodeJson();
        $usernameExists = false;

        for ($i = 0; $i < count($accounts); $i++) {
            if ($accounts[$i][self::$USERNAME_SEARCH_STRING] === $enteredUsername) {
                $usernameExists = true;
            }
        }

        if ($usernameExists) {
            throw new \UserAlreadyExistException('User tried to create existing user');
        }
    }

    public function addUserToDB(\model\User $user) {
        $json = $this->decodeJson();
        $newCredArray = array();
        $newCredArray = $user;

        array_push($json, $newCredArray);

        if ($user !== NULL ) {
            $this->saveDB($json);
        }
    }

    public function saveDB($newJson) {
        $encodedJson = json_encode($newJson);
        file_put_contents(self::$DATABASE_LOCATION, $encodedJson);
    }

}
