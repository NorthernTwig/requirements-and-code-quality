<?php

namespace view;

require_once('LayoutView.php');

class RegisterView {
	private static $messageId = 'RegisterView::Message';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $message = '';

	public function __construct() {
		$rv = new LayoutView();
		$rv->toOutputBuffer($this->generateRegisterForm());
	}

	private function generateRegisterForm() {
		return '
		<h2>Register new user</h2>
		<form action="?register" method="post" enctype="multipart/form-data">
		<fieldset>
		<legend>Register a new user - Write username and password</legend>
		<p id="' . self::$messageId . '">Message</p>
		<label for="' . self::$name . '">Username :</label>
		<input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="Reg">
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


	// public function render() {
	// 	echo '<h1>Register</h1>';
	// }


	// public function response() {
	//
	// 	if (isset($_POST[self::$name])) {
	// 		$this->setMessage();
	// 	}
	//
	// 	$response = $this->generateRegisterForm(self::$message);
	//
	// 	return $response;beautif
	//
	// }


	// private function setMessage() {
	//
	// 	if (!$this->usernameCheck()) {
	// 		self::$message = 'Username has too few characters, at least 3 characters.<br>';
	// 	}
	//
	// 	if (!$this->passwordCheck()) {
	// 		self::$message .= 'Password has too few characters, at least 6 characters.<br>';
	// 	}
	//
	// 	if (!$this->passwordMatch()) {
	// 		self::$message .= 'Passwords do not match.';
	// 	}
	//
	// }
	//
	// private function () {
	// 	$name = "";
	// 	if (isset($_POST[self::$name])) {
	// 		$name = $_POST[self::$name];
	// 	}
	//
	// 	return $name;
	// }
	//
	// private function passwordCheck() {
	// 	$validPassword = false;
	// 	if (isset($_POST[self::$password])) {
	// 		if (strlen($_POST[self::$password]) >= 6) {
	// 			$validPassword = true;
	// 		}
	// 	}
	// 	return $validPassword;
	// }
	//
	// private function usernameCheck() {
	// 	$validUsername = false;
	//
	// 	if (isset($_POST[self::$name])) {
	// 		if (strlen($_POST[self::$name]) >= 3) {
	// 			$validUsername = true;
	// 		}
	// 	}
	//
	// 	return $validUsername;
	// }
	//
	// private function passwordMatch() {
	// 	$matching = false;
	// 	if (isset($_POST[self::$password]) && isset($_POST[self::$passwordRepeat])) {
	// 		if ($_POST[self::$password] == $_POST[self::$passwordRepeat]) {
	// 			$matching = true;
	// 		}
	// 	}
	// 	return $matching;
	// }


}
