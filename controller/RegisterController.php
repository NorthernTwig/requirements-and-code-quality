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

        try {

            if ($this->rw->isRegistering()) {
                $this->checkEnteredDetails();
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        } finally {
            $this->rw->registerToLayoutView($this->flashModel, $this->sessionModel);
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
            // $this->rw->checkRegisterPassword();
            // $this->rw->passwordsMatch();
        }

        private function usernameValidation() {
            $username = $this->rw->getRegisterUsername();
            $isValid = $this->db->validateUsername($username);
            if (!$isValid) {
                $username = $this->db->stripUsername($username);
                $this->flashModel->setFlashMessage($this->rw->getUsernameInvalidCharacters());
            }
            $this->usernameModel->setUsernameUsedInCredentials($username);
        }

}
