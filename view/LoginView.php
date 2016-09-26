<?php

namespace view;

require_once('LayoutView.php');
require_once('model/FlashModel.php');

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	public function __construct() {
		if (!isset($_SESSION['username'])) {
			$_SESSION['username'] = '';
		}
	}

	//iseoighse
	public function toLayoutView($flashModel, $sessionModel) {
		$this->sessionModel = $sessionModel;
		$lv = new LayoutView($sessionModel);
		$this->flashModel = $flashModel;

		if ($this->isLoggingIn() || $this->isLoggingOut()) {
			$flashMessage = $_SESSION['message'];
		} else {
			$flashMessage = $this->flashModel->getFlashMessage();
		}

		if ($this->sessionModel->getIsLoggedIn()) {
			$lv->toOutputBuffer($this->generateLogoutButtonHTML($flashMessage));
		} else {
			$lv->toOutputBuffer($this->generateLoginForm($flashMessage));
		}
	}

	private function generateLoginForm($message) {
			return '
				<form method="post">
					<fieldset>
						<legend>Login - enter Username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>

						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $_SESSION['username'] . '" />

						<label for="' . self::$password . '">Password :</label>
						<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

						<label for="' . self::$keep . '">Keep me logged in  :</label>
						<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

						<input type="submit" name="' . self::$login . '" value="login" />
					</fieldset>
				</form>
			';
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	private function setUsernameValue() {
		if (isset($_POST[self::$name])) {
			return $_POST[self::$name];
		}
	}

	public function getUsername() {

			if (strlen($_POST[self::$name]) == 0) {
				throw new \Exception('Username is missing');
			}

		return $_POST[self::$name];

	}

	public function getPassword() {
		if (strlen($_POST[self::$password]) == 0) {
			throw new \Exception('Password is missing');
		}
		return $_POST[self::$password];
	}

	public function isLoggingIn() {
		return isset($_POST[self::$login]);
	}

	public function isLoggingOut() {
		return isset($_POST[self::$logout]);
	}

	public function isKeepingLogin() {
		return isset($_POST[self::$keep]);
	}

}
