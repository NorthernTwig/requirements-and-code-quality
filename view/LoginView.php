<?php

namespace view;

require_once('LayoutView.php');
require_once('model/FlashModel.php');
require_once('exceptions/NoUsernameException.php');
require_once('exceptions/NoPasswordException.php');

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	public function __construct($usernameModel) {
		$usernameModel->resetUsernameFromCredentials();
	}

	public function loginToLayoutView($flashModel, $sessionModel, $usernameModel) {
		$this->usernameModel = $usernameModel;
		$this->sessionModel = $sessionModel;
		$this->lv = new LayoutView($sessionModel);
		$this->flashModel = $flashModel;
		$this->flashMessage = $this->flashModel->getFlashMessage();

		if ($this->sessionModel->getIsLoggedIn()) {
			$this->lv->toOutputBuffer($this->generateLogoutButtonHTML($this->flashMessage));
		} else {
			$this->lv->toOutputBuffer($this->generateLoginForm($this->flashMessage));
		}
	}

	private function generateLoginForm($message) {
			return '
				<form method="post">
					<fieldset>
						<legend>Login - enter Username and password</legend>
						<p id="' . self::$messageId . '">' . $message . '</p>

						<label for="' . self::$name . '">Username :</label>
						<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->usernameModel->getUsernameUsedInCredentials() . '" />

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

	public function getUsername() {
			if (strlen($_POST[self::$name]) == 0) {
				throw new \NoUsernameException('Username is missing');
			}
		return $_POST[self::$name];
	}

	public function getPassword() {
		if (strlen($_POST[self::$password]) == 0) {
			throw new \NoPasswordException('Password is missing');
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

	private function setUsernameCookie() {
	  setcookie(self::$COOKIE_NAME_STRING, self::$username, time()+36000);
	}

	private function setPasswordCookie() {
	  setcookie(self::$COOKIE_PASSWORD_STRING, self::$password, time()+36000);
	}

	private function removeUsernameCookie() {
	  setcookie(self::$COOKIE_NAME_STRING, NULL, time()-1);
	}

	private function removePasswordCookie() {
	  setcookie(self::$COOKIE_PASSWORD_STRING, NULL, time()-1);
	}

}
