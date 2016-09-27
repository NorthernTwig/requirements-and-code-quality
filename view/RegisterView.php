<?php

namespace view;

require_once('LayoutView.php');

class RegisterView {
	private static $messageId = 'RegisterView::Message';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $message = '';

	public function registerToLayoutView($flashModel, $sessionModel) {
		$rv = new LayoutView($sessionModel);
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
		<input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="">
		<br>
		<label for="' . self::$password . '">Password  :</label>
		<input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="">
		<br>
		<label for="' . self::$passwordRepeat . '">Repeat password  :</label>
		<input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="">
		<br>
		<input id="submit" type="submit" name="DoRegistration" value="Register">
		<br>
		</fieldset>
		</form>';
	}

	private function getMessage() {
		return self::$message;
	}

	public function checkRegisterUsername() {

		if (isset($_POST[self::$name])) {
			if (strlen($_POST[self::$name]) < 3) {
				self::$message .= 'Username has too few characters, at least 3 characters.<br>';
			}

			return $_POST[self::$name];
		}

	}

	public function checkRegisterPassword() {
		if (isset($_POST[self::$password])) {

			if (strlen($_POST[self::$password]) < 6) {
				self::$message .= 'Password has too few characters, at least 6 characters.<br>';
			}

			return $_POST[self::$password];
		}
	}

	public function passwordsMatch() {
		if (isset($_POST[self::$password]) && isset($_POST[self::$passwordRepeat])) {
			if ($_POST[self::$password] !== $_POST[self::$passwordRepeat]) {
				self::$message .= 'Passwords do not match.';
			}
		}
	}

}
