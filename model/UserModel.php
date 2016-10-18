<?php

namespace model;

class UserModel {
    public function __construct(string $username) {
        $this->validateUsername();
    }

    private function validateUsername(string $username) : bool {
        $isInvalid = $this->hasInvalidCharacters();
    }

    private function hasInvalidCharacters() {
        preg_match('/^[a-zA-Z0-9]+$/', $username, $matches);
        return count($matches) > 0;
    }

    private function isTooShort() {
        return 'nope';
    }

}
