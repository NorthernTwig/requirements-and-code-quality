<?php

namespace controller;

require_once('view/RegisterView.php');
require_once('model/FlashModel.php');
require_once('model/SessionModel.php');
require_once('BaseController.php');
require_once('model/DAL.php');
require_once('model/UserModel.php');

class RegisterController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->rw = new \view\RegisterView($this->usernameModel);
        $this->flashModel->resetMessageFromCredentials();

        try {

            if ($this->rw->isRegistering()) {
                $username = $this->rw->getUsernameForRegister();
                $this->usernameModel->setUsernameUsedInCredentials($username);
                $password = $this->rw->getPasswordForRegister();
                $passwordMatch = $this->rw->getPasswordMatchForRegister();
                $user = new \model\UserModel($username, $password, $passwordMatch);
                $this->db->compareUsernameWithDatabase($username);
                $this->db->addUserToDB($user);
                $this->flashModel->setFlashMessage($this->rw->getNewRegisterMessage());
                header('Location: /');
                exit();
            }

        } catch (\InvalidSymbolsUsernameException $e) {
            $this->flashModel->setFlashMessage($this->rw->getUsernameInvalidCharacters());
        } catch (\UsernameTooShortException $e) {
            $this->flashModel->setFlashMessage($this->rw->getUsernameTooShortMessage());
        } catch (\UsernameTooShortException $e) {
            $this->flashModel->setFlashMessage($this->rw->getUsernameTooShortMessage());
        } catch (\PasswordTooShortException $e) {
           $this->flashModel->setFlashMessage($this->rw->getPasswordTooShortMessage());
        } catch (\PasswordsDoNotMatchException $e) {
            $this->flashModel->setFlashMessage($this->rw->getPasswordsNotMatchMessage());
        } catch (\UserAlreadyExistException $e) {
            $this->flashModel->setFlashMessage($this->rw->getUserAlreadyExistsMessage());
        } catch (\NoEnteredCredentials $e) {
            $this->flashModel->setFlashMessage($this->rw->getNoEnteredCredentials());
        }  catch (\Exception $e) {
            var_dump($e->getMessage());
        } finally {
            $this->rw->registerToLayoutView($this->flashModel, $this->sessionModel);
        }
    }
}
