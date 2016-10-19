<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('BaseController.php');
require_once('model/DAL.php');
require_once('model/UserModel.php');

class RegisterController extends BaseController {

    private $registerView;

    public function __construct() {
        parent::__construct();
        $this->registerView = new \view\RegisterView($this->usernameModel, $this->sessionModel);
        $this->flashModel->resetMessageFromCredentials();

        try {

            if ($this->registerView->isRegistering()) {
                $username = $this->registerView->getUsernameForRegister();
                $this->usernameModel->setUsernameUsedInCredentials($username);
                $password = $this->registerView->getPasswordForRegister();
                $passwordMatch = $this->registerView->getPasswordMatchForRegister();
                $user = new \model\UserModel($username, $password, $passwordMatch);
                $this->dal->compareUsernameWithDatabase($username);
                $this->dal->addUserToDB($user->newUser());
                $this->flashModel->setFlashMessage($this->registerView->getNewRegisterMessage());
                $this->registerView->redirectToLogin();
            }

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
}
