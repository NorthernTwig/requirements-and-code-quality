<?php

namespace view;

require_once('LayoutView.php');
require_once('GetFlashMessages.php');
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
	private static $COOKIE_NAME_STRING = 'Username';
	private static $COOKIE_PASSWORD_STRING = 'Password';

	public function __construct($usernameModel, $sessionModel) {
		$this->lv = new LayoutView($sessionModel, false);
		$this->sessionModel = $sessionModel;
		$this->getFlashMessages = new \view\GetFlashMessages();
		$usernameModel->resetUsernameFromCredentials();
	}

	public function loginToLayoutView($flashModel, $usernameModel) {
		$this->usernameModel = $usernameModel;
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . strip_tags($this->getLoginName()) . '" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function reloadLogin() {
		$this->lv->redirect();
	}

	private function getLoginName() {
		return $this->usernameModel->getUsernameUsedInCredentials();
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	public function getUsername() : string {
		if (strlen($_POST[self::$name]) == 0) {
			throw new \NoUsernameException('No username entered.');
		}
		return $_POST[self::$name];
	}

	public function getPassword() : string {
		if (strlen($_POST[self::$password]) == 0) {
			throw new \NoPasswordException('No password entered.');
		}
		return $_POST[self::$password];
	}

	public function getWelcomeRemember() : string {
		return $this->getFlashMessages->setWelcomeRemember();
	}

	public function getWelcomeCookie() : string {
		return $this->getFlashMessages->setWelcomeCookie();
	}

	public function getWelcomeStandard() : string {
		return $this->getFlashMessages->setWelcomeStandard();
	}

	public function getWrongUsernameMessage() : string {
		return $this->getFlashMessages->setWrongUsernameMessage();
	}

	public function getWrongPasswordMessage() : string {
		return $this->getFlashMessages->setWrongPasswordMessage();
	}

	public function getWrongCredentials() : string {
		return $this->getFlashMessages->setWrongCredentials();
	}

	public function getLogoutMessage() : string {
		return $this->getFlashMessages->setLogoutMessage();
	}

	public function isLoggingIn() : bool {
		return isset($_POST[self::$login]);
	}

	public function isLoggingOut() : bool {
		return isset($_POST[self::$logout]);
	}

	public function isKeepingLogin() : bool {
		return isset($_POST[self::$keep]);
	}

	public function hasUsernameCookie() {
		return isset($_COOKIE[self::$COOKIE_NAME_STRING]);
	}

	public function hasPasswordCookie() {
		return isset($_COOKIE[self::$COOKIE_PASSWORD_STRING]);
	}

	public function getUsernameCookie() {
		return $_COOKIE[self::$COOKIE_NAME_STRING];
	}

	public function getPasswordCookie() {
		return $_COOKIE[self::$COOKIE_PASSWORD_STRING];
	}

	public function setUsernameCookie() {
		setcookie(self::$COOKIE_NAME_STRING, $_POST[self::$name], time() + 36000);
	}

	public function setPasswordCookie() {
		setcookie(self::$COOKIE_PASSWORD_STRING, $_POST[self::$password], time() + 36000);
	}

	public function removeUsernameCookie() {
		setcookie(self::$COOKIE_NAME_STRING, NULL, time() - 1 );
	}

	public function removePasswordCookie() {
		setcookie(self::$COOKIE_PASSWORD_STRING, NULL, time() - 1 );
	}
}
