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

    private static $username = '';
    private static $password = '';

    public function __construct() {
        parent::__construct();
        $this->lv = new \view\LoginView($this->usernameModel);

        try {

            if ($this->hasCookiesTryingToLogin()) {
                $this->triesToLoginUserWithCookies();
            } else if ($this->isTryingToLogIn()) {
                $this->triesToAuthenticateUser();
            } else if ($this->isTryingToLogOut()) {
                $this->triesToLogoutUser();
            }

            if ($this->lv->isLoggingIn() || $this->lv->isLoggingOut()) {
                header('Location: /');
                exit();
            }

        } catch (\NoUsernameException $e) {
            $this->flashModel->setFlashMessage($this->lv->getWrongUsernameMessage());
        } catch (\NoPasswordException $e) {
            $this->flashModel->setFlashMessage($this->lv->getWrongPasswordMessage());
        } catch (\WrongCredentialsException $e) {
            $this->flashModel->setFlashMessage($this->lv->getWrongCredentials());
        } catch (\Exception $e) {
            $this->flashModel->setFlashMessage($e->getMessage());
        } finally {
            $this->checkIfStoreUsername();
            $this->lv->loginToLayoutView($this->flashModel, $this->sessionModel, $this->usernameModel);
            $this->flashModel->setFlashMessage('');
        }
    }

    private function checkIfStoreUsername() {
        if (strlen(self::$username) > 0) {
            $this->usernameModel->setUsernameUsedInCredentials(self::$username);
        }
    }

    private function hasCookiesTryingToLogin() : bool {
        if ($this->lv->hasUsernameCookie() && !$this->lv->isLoggingOut()) {
            return true;
        }
        return false;
    }

    private function triesToLoginUserWithCookies() {
        self::$username = $this->lv->getUsernameCookie();
        self::$password = $this->lv->getPasswordCookie();
        $this->compareEnteredCredentials();
    }

    private function isTryingToLogIn() : bool {
        if ($this->lv->isLoggingIn() && !$this->sessionModel->getIsLoggedIn()) {
            return true;
        }
        return false;
    }

    private function isTryingToLogOut() : bool {
        if ($this->lv->isLoggingOut() && $this->sessionModel->getIsLoggedIn()) {
            return true;
        }
        return false;
    }

    private function triesToLogoutUser() {
        $this->removeUserCredentialsInCookie();
        $this->usernameModel->removeStoredUsername();
        $this->sessionModel->setIsLoggedIn(false);
        $this->flashModel->setFlashMessage($this->lv->getLogoutMessage());
    }

    private function triesToAuthenticateUser() {
        $this->setUsername();
        $this->setPassword();
        $this->compareEnteredCredentials();
        $this->storeUserCredentialsInCookie();
    }

    private function compareEnteredCredentials() {
        $this->db->compareCredentials(self::$username, self::$password);

        if ($this->lv->isKeepingLogin()) {
            $this->flashModel->setFlashMessage($this->lv->getWelcomeRemember());
        } else if (!$this->sessionModel->getIsLoggedIn() && $this->lv->hasUsernameCookie()) {
            $this->flashModel->setFlashMessage($this->lv->getWelcomeCookie());
        } else if (!$this->sessionModel->getIsLoggedIn()) {
            $this->flashModel->setFlashMessage($this->lv->getWelcomeStandard());
        }
        $this->sessionModel->setIsLoggedIn(true);
    }

    private function setUsername() {
        if ($this->lv->hasUsernameCookie()) {
            self::$username = $this->lv->getUsernameCookie();
        } else {
            self::$username = $this->lv->getUsername();
        }
    }

    private function setPassword() {
        if ($this->lv->hasPasswordCookie()) {
            self::$password = $this->lv->getPasswordCookie();
        } else {
            self::$password = $this->lv->getPassword();
        }
    }

    public function storeUserCredentialsInCookie() {
        if ($this->lv->isKeepingLogin()) {
            $this->lv->setUsernameCookie();
            $this->lv->setPasswordCookie();
        }
    }

    public function removeUserCredentialsInCookie() {
        $this->lv->removeUsernameCookie();
        $this->lv->removePasswordCookie();
    }
}
