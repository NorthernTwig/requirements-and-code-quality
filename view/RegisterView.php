<?php

namespace view;

require_once("GetFlashMessages.php");
require_once('LayoutView.php');

class RegisterView {
	private static $messageId = 'RegisterView::Message';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $register = 'RegisterView::Register';
	private static $message = '';
	private static $successfull_registration = true;

	public function __construct() {
		$this->getFlashMessages = new GetFlashMessages();
		if (!isset($_SESSION['username'])) {
			$_SESSION['username'] = '';
		}
	}

	public function registerToLayoutView($flashModel, $sessionModel) {
		$rv = new LayoutView($sessionModel);
		$this->flashModel = $flashModel;
		$rv->toOutputBuffer($this->generateRegisterForm());
	}

	private function generateRegisterForm() {
		return '
		<h2>Register new user</h2>
			<form action="?register" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Register a new user - Write username and password</legend>
				<p id="' . self::$messageId . '">' . $this->getMessage() . '</p>
				<label for="' . self::$name . '">Username :</label>
				<input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . $_SESSION['username'] . '">
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
		</form>';
	}

	public function getMessage() {
		return self::$message;
	}

	private function cleanUpUsername($username) {
		$cleanedUsername = strip_tags($username);
		return $cleanedUsername;
	}

	private function checkForInvalidCharacters() {
		preg_match('/^[a-zA-Z0-9]+$/', $_POST[self::$name], $matches);
		$_SESSION['username'] = $this->cleanUpUsername($_POST[self::$name]);
		return count($matches) > 0;
	}

	public function checkRegisterUsername() {
		if (isset($_POST[self::$name])) {
			if (strlen($_POST[self::$name]) < 3) {
				self::$message .= $this->getFlashMessages->setUsernameInvalidCharacters();
				self::$message .= '<br>';
				$_SESSION['username'] = $_POST[self::$name];
				self::$successfull_registration = false;
			} else if (!$this->checkForInvalidCharacters()) {
				self::$message .= $this->getFlashMessages->setUsernameInvalidCharacters();
				self::$message .= '<br>';
				self::$successfull_registration = false;
			}
		}
	}

	public function checkRegisterPassword() {
		if (isset($_POST[self::$password])) {
			if (strlen($_POST[self::$password]) < 6) {
				self::$message .= $this->getFlashMessages->setPasswordTooShortMessage();
				self::$message .= '<br>';
				self::$successfull_registration = false;
			}
		}
	}

	public function passwordsMatch() {
		if (isset($_POST[self::$password]) && isset($_POST[self::$passwordRepeat])) {
			if ($_POST[self::$password] !== $_POST[self::$passwordRepeat]) {
				self::$message .= $this->getFlashMessages->setPasswordsNotMatchMessage();
				self::$successfull_registration = false;
			}
		}
	}

	public function setRegisterExistsMessage() {
		self::$message = $this->getFlashMessages->setUserAlreadyExistsMessage();
		self::$successfull_registration = false;
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

	public function registerSuccessfull() {
		return self::$successfull_registration;
	}

	public function isRegistering() {
		if (isset($_POST[self::$register])) {
			if ($_POST[self::$register] != NULL) {
				return true;
			}
		}
	}

}
