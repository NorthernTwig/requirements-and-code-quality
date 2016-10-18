<?php

namespace view;

require_once("GetFlashMessages.php");
require_once("model/UserModel.php");
require_once('LayoutView.php');

class RegisterView {

	private static $messageId = 'RegisterView::Message';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $register = 'RegisterView::Register';
	private static $message = '';

	public function __construct($usernameModel) {
		$this->getFlashMessages = new GetFlashMessages();
		$this->usernameModel = $usernameModel;
	}

	public function registerToLayoutView($flashModel, $sessionModel) {
		$this->layoutView = new LayoutView($sessionModel, true);
		$this->flashModel = $flashModel;
		$this->layoutView->toOutputBuffer($this->generateRegisterForm());
	}

	private function generateRegisterForm() : string {
		return '
			<h2>Register new user</h2>
			<form action="?register" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id="' . self::$messageId . '">' . $this->getMessage() . '</p>
					<label for="' . self::$name . '">Username :</label>
					<input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . strip_tags($this->getRegisterName()) . '">
					<br>
					<label for="' . self::$password . '">Password  :</label>
					<input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="">
					<br>
					<label for="' . self::$passwordRepeat . '">Repeat password  :</label>
					<input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="">
					<br>
					<input id="submit" type="submit" name="' . self::$register . '" value="Register">
					<br>
				</fieldset>
			</form>
		';
	}

	private function getRegisterName() {
		return $this->usernameModel->getUsernameUsedInCredentials();
	}

	public function getMessage() : string {
		return $this->flashModel->getFlashMessage();
	}

	public function getRegisterUsername() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
	}

	public function setRegisterExistsMessage() {
		self::$message = $this->getFlashMessages->setUserAlreadyExistsMessage();
	}

	public function getUsernameForRegister() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
	}

	public function getPasswordForRegister() {
		if (isset($_POST[self::$password])) {
			return $_POST[self::$password];
		}
	}

	public function getPasswordMatchForRegister() {
		if (isset($_POST[self::$passwordRepeat])) {
			return $_POST[self::$passwordRepeat];
		}
	}

	public function registerSuccessfull() {
		return self::$successfull_registration;
	}

	public function isRegistering() {
		if (isset($_POST[self::$register])) {
			return true;
		}
	}

	public function getUsernameInvalidCharacters() : string {
		return $this->getFlashMessages->setUsernameInvalidCharacters();
	}

	public function getUsernameTooShortMessage() : string {
		return $this->getFlashMessages->setUsernameTooShortMessage();
	}

	public function getPasswordTooShortMessage() : string {
		return $this->getFlashMessages->setPasswordTooShortMessage();
	}

	public function getPasswordsNotMatchMessage() : string {
		return $this->getFlashMessages->setPasswordsNotMatchMessage();
	}

	public function getUserAlreadyExistsMessage() : string {
		return $this->getFlashMessages->setUserAlreadyExistsMessage();
	}

	public function getNoEnteredCredentials() : string {
		return $this->getFlashMessages->setNoEnteredCredentials();
	}

	public function getNewRegisterMessage() : string {
		return $this->getFlashMessages->setNewRegisterMessage();
	}

}
