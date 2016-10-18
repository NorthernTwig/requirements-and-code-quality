<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('BaseController.php');
require_once('model/DAL.php');


class RegisterController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->rw = new \view\RegisterView($this->usernameModel);
        $this->flashModel->resetMessageFromCredentials();


        try {

            if ($this->rw->isRegistering()) {
                $this->checkEnteredDetails();
            }

        } catch (\InvalidSymbolsUsernameException $e) {
            $cleanUsername = $this->db->stripUsername($this->usernameModel->getUsernameUsedInCredentials());
            $this->usernameModel->setUsernameUsedInCredentials($cleanUsername);
            $this->flashModel->setFlashMessage($this->rw->getUsernameInvalidCharacters());
        } catch (\UsernameTooShortException $e) {
            $this->flashModel->setFlashMessage($this->rw->getUsernameTooShortMessage());
        } catch (\UsernameTooShortException $e) {
            $this->flashModel->setFlashMessage($this->rw->getUsernameTooShortMessage());
        } catch (\PasswordTooShortException $e) {
           $this->flashModel->setFlashMessage($this->rw->getPasswordTooShortMessage());
        } catch (\PasswordsDoNotMatchException $e) {
            $this->flashModel->setFlashMessage($this->rw->getPasswordsNotMatchMessage());
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        } finally {
            $this->rw->registerToLayoutView($this->flashModel, $this->sessionModel);
            // if ($this->rw->registerSuccessfull()) {
                // $this->flashModel->setFlashMessage('nytt');
                // header('Location: /');
                // exit();
            // }
        }

        // try {
        //     if (strlen($this->rw->getUsernameForRegister()) > 0 && $this->rw->isRegistering() && $db->compareUsername($this->rw->getUsernameForRegister())) {
        //         $this->rw->setRegisterExistsMessage();
        //     } else if ($this->rw->isRegistering()) {
        //         if ($this->rw->registerSuccessfull()) {
        //             $db->addUserToDB($this->rw->getUsernameForRegister(), $this->rw->getPasswordForRegister());
        //             $this->flashModel->setFlashMessage($this->getFlashMessages->setNewRegisterMessage());
        //             header('Location: /');
        //             exit();
        //         }
        //     }
        //
        // } catch (\Exception $e) {
        //     $this->flashModel->setFlashMessage($e->getMessage());
    }

        private function checkEnteredDetails() {
            $this->usernameValidation();
            $this->passwordValidation();
            // $this->rw->passwordsMatch();
        }

        private function passwordValidation() {
            $password = $this->rw->getPasswordForRegister();
            $passwordMatch = $this->rw->getPasswordMatchForRegister();
            $this->db->validatePassword($password, $passwordMatch);
        }

        private function usernameValidation() {
            $username = $this->rw->getUsernameForRegister();
            $this->usernameModel->setUsernameUsedInCredentials($username);
            $isValid = $this->db->validateUsername($username);
        }

}
