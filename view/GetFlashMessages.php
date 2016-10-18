<?php

namespace view;

class GetFlashMessages {

    public function setWelcomeRemember() : string {
        return 'Welcome and you will be remembered';
    }

    public function setWelcomeCookie() : string {
        return 'Welcome back with cookie';
    }

    public function setWelcomeStandard() : string {
        return 'Welcome';
    }

    public function setWrongCredentials() : string {
        return 'Wrong name or password';
    }

    public function setLogoutMessage() : string {
        return 'Bye bye!';
    }

    public function setWrongUsernameMessage() : string {
        return 'Username is missing';
    }

    public function setWrongPasswordMessage() : string {
        return 'Password is missing';
    }

    public function setNewRegisterMessage() : string {
        return 'Registered new user.';
    }

    public function setPasswordTooShortMessage() : string {
        return 'Password has too few characters, at least 6 characters.';
    }

    public function setPasswordsNotMatchMessage() : string {
        return 'Passwords do not match.';
    }

    public function setUsernameTooShortMessage() : string {
        return 'Username has too few characters, at least 3 characters.';
    }

    public function setUserAlreadyExistsMessage() : string {
        return 'User exists, pick another username.';
    }

    public function setUsernameInvalidCharacters() : string {
        return 'Username contains invalid characters.';
    }

    public function setNoEnteredCredentials() : string {
        return $this->setUsernameTooShortMessage() . ' <br> ' . $this->setPasswordTooShortMessage();
    }

}
