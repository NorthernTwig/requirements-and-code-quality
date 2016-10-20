<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('BaseController.php');
require_once('model/UserModel.php');

class RegisterController extends BaseController {

    private $registerView;
    private $username;
    private $password;
    private $user;
    private $passwordMatch;

    public function __construct() {
        parent::__construct();
        $this->registerView = new \view\RegisterView($this->usernameModel, $this->sessionModel);
        $this->flashModel->resetMessageFromCredentials();
    }

    public function registerInit() {
        try {

            $this->triesRegisterWithCredentials();

        } catch (\InvalidSymbolsUsernameException $e) {
            $this->flashModel->setFlashMessage($this->registerView->getUsernameInvalidCharacters());
        } catch (\UsernameTooShortException $e) {
            $this->flashModel->setFlashMessage($this->registerView->getUsernameTooShortMessage());
        } catch (\UsernameTooShortException $e) {
            $this->flashModel->setFlashMessage($this->registerView->getUsernameTooShortMessage());
        } catch (\PasswordTooShortException $e) {
           $this->flashModel->setFlashMessage($this->registerView->getPasswordTooShortMessage());
        } catch (\PasswordsDoNotMatchException $e) {
            $this->flashModel->setFlashMessage($this->registerView->getPasswordsNotMatchMessage());
        } catch (\UserAlreadyExistException $e) {
            $this->flashModel->setFlashMessage($this->registerView->getUserAlreadyExistsMessage());
        } catch (\NoEnteredCredentials $e) {
            $this->flashModel->setFlashMessage($this->registerView->getNoEnteredCredentials());
        } finally {
            $this->registerView->registerToLayoutView($this->flashModel, $this->sessionModel);
        }
    }

    public function getShouldRenderRegister() {
        return $this->registerView->shouldRenderRegister();
    }

    private function triesRegisterWithCredentials() {
        if ($this->registerView->isRegistering()) {
            $this->obtainAndSetRegisterUsername();
            $this->obtainAndSetRegisterPassword();
            $this->tryCreateUser();
            $this->setFlashMessageAndRedirect();
        }
    }

    private function obtainAndSetRegisterUsername() {
        $this->username = $this->registerView->getUsernameForRegister();
        $this->usernameModel->setUsernameUsedInCredentials($this->username);
    }

    private function obtainAndSetRegisterPassword() {
        $this->password = $this->registerView->getPasswordForRegister();
        $this->passwordMatch = $this->registerView->getPasswordMatchForRegister();
    }

    private function tryCreateUser() {
        $this->user = new \model\UserModel($this->username, $this->password, $this->passwordMatch);
        $this->dal->compareUsernameWithDatabase($this->username);
        $this->dal->addUserToDB($this->user->newUser());
    }

    private function setFlashMessageAndRedirect() {
        $this->flashModel->setFlashMessage($this->registerView->getNewRegisterMessage());
        $this->registerView->redirectToLogin();
    }
}
