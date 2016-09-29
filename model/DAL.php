<?php

namespace model;

class DAL {

  public function __construct() {
    $this->jsonString = file_get_contents('./database/UserCredentials.json');
  }

  public function decodeJson() {
    return json_decode($this->jsonString, true);
  }

  public function loopThroughCredentials($enteredUsername, $enteredPassword) {
    $accounts = $this->decodeJson();
    $userExists = false;

    for ($i=0; $i < count($accounts); $i++) {
      if ($accounts[$i]['username'] === $enteredUsername && $accounts[$i]['password'] === $enteredPassword) {
        $userExists = true;
      }
    }

    return $userExists;

  }

}
