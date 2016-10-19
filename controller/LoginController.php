<?php

namespace controller;

require_once('view/LoginView.php');
require_once('view/GetFlashMessages.php');
require_once('model/FlashModel.php');
require_once('model/DAL.php');
require_once('model/SessionModel.php');
require_once('view/GetFlashMessages.php');
require_once('BaseController.php');

class LoginController extends BaseController {

    private $username;
    private $password;
    private $layoutView;
    private $user;

    public function __construct() {
        parent::__construct();
        $this->layoutView = new \view\LoginView($this->usernameModel, $this->sessionModel);

        try {

            $this->ifLoginTryToAuthenticate();
            $this->ifTriesLoginOrOutRedirect();

        } catch (\NoUsernameException $e) {
            $this->flashModel->setFlashMessage($this->layoutView->getWrongUsernameMessage());
        } catch (\NoPasswordException $e) {
            $this->flashModel->setFlashMessage($this->layoutView->getWrongPasswordMessage());
        } catch (\WrongCredentialsException $e) {
            $this->flashModel->setFlashMessage($this->layoutView->getWrongCredentials());
        } finally {
            $this->checkIfStoreUsername();
            $this->layoutView->loginToLayoutView($this->flashModel, $this->usernameModel);
            $this->flashModel->setFlashMessage('');
        }
    }

    private function ifLoginTryToAuthenticate() {
        if ($this->hasCookiesTryingToLogin()) {
            $this->triesToLoginUserWithCookies();
        } else if ($this->isTryingToLogIn()) {
            $this->triesToAuthenticateUser();
        } else if ($this->isTryingToLogOut()) {
            $this->triesToLogoutUser();
        }
    }

    private function ifTriesLoginOrOutRedirect() {
        if ($this->layoutView->isLoggingIn() || $this->layoutView->isLoggingOut()) {
            $this->layoutView->reloadLogin();
        }
    }

    private function checkIfStoreUsername() {
        if (strlen($this->username) > 0) {
            $this->usernameModel->setUsernameUsedInCredentials($this->username);
        }
    }

    private function hasCookiesTryingToLogin() : bool {
        return $this->layoutView->hasUsernameCookie() && !$this->layoutView->isLoggingOut();
    }

    private function triesToLoginUserWithCookies() {
        $this->username = $this->layoutView->getUsernameCookie();
        $this->password = $this->layoutView->getPasswordCookie();
        $this->compareEnteredCredentials();
    }

    private function isTryingToLogIn() : bool {
        return $this->layoutView->isLoggingIn() && !$this->sessionModel->getIsLoggedIn();
    }

    private function isTryingToLogOut() : bool {
        return $this->layoutView->isLoggingOut() && $this->sessionModel->getIsLoggedIn();
    }

    private function triesToLogoutUser() {
        $this->removeUserCredentialsInCookie();
        $this->usernameModel->removeStoredUsername();
        $this->sessionModel->setIsLoggedIn(false);
        $this->flashModel->setFlashMessage($this->layoutView->getLogoutMessage());
    }

    private function triesToAuthenticateUser() {
        $this->setUsername();
        $this->setPassword();
        $this->compareEnteredCredentials();
        $this->storeUserCredentialsInCookie();
    }

    private function compareEnteredCredentials() {
        $this->dal->compareCredentials($this->username, $this->password);

        if ($this->layoutView->isKeepingLogin()) {
            $this->flashModel->setFlashMessage($this->layoutView->getWelcomeRemember());
        } else if (!$this->sessionModel->getIsLoggedIn() && $this->layoutView->hasUsernameCookie()) {
            $this->flashModel->setFlashMessage($this->layoutView->getWelcomeCookie());
        } else if (!$this->sessionModel->getIsLoggedIn()) {
            $this->flashModel->setFlashMessage($this->layoutView->getWelcomeStandard());
        }

        $this->sessionModel->setIsLoggedIn(true);
    }

    private function setUsername() {
        if ($this->layoutView->hasUsernameCookie()) {
            $this->username = $this->layoutView->getUsernameCookie();
        } else {
            $this->username = $this->layoutView->getUsername();
        }
    }

    private function setPassword() {
        if ($this->layoutView->hasPasswordCookie()) {
            $this->password = $this->layoutView->getPasswordCookie();
        } else {
            $this->password = $this->layoutView->getPassword();
        }
    }

    public function storeUserCredentialsInCookie() {
        if ($this->layoutView->isKeepingLogin()) {
            $this->layoutView->setUsernameCookie();
            $this->layoutView->setPasswordCookie();
        }
    }

    public function removeUserCredentialsInCookie() {
        $this->layoutView->removeUsernameCookie();
        $this->layoutView->removePasswordCookie();
    }
}
