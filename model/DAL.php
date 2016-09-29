<?php

namespace model;

class DAL {

  public function __construct() {
    $this->jsonString = file_get_contents('./database/UserCredentials.json');
  }

  public function decodeJson() {
    return json_decode($this->jsonString, true);
  }

  public function compareCredentials($enteredUsername, $enteredPassword) {
    $accounts = $this->decodeJson();
    $isCredentialsCorrect = false;

    for ($i=0; $i < count($accounts); $i++) {
      if ($accounts[$i]['username'] === $enteredUsername && $accounts[$i]['password'] === $enteredPassword) {
        $isCredentialsCorrect = true;
      }
    }

    return $isCredentialsCorrect;

  }

  public function compareUsername($enteredUsername) {
    $accounts = $this->decodeJson();
    $usernameExists = false;

    for ($i=0; $i < count($accounts); $i++) {
      if ($accounts[$i]['username'] === $enteredUsername) {
        $usernameExists = true;
      }
    }

    return $usernameExists;

  }

}
