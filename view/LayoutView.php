<?php

namespace view;

require_once('DateTimeView.php');

class LayoutView {

    public function __construct($sessionModel, $isRegisterView) {
        $this->date = new DateTimeView();
        $this->isRegisterView = $isRegisterView;
        $this->sessionModel = $sessionModel;
    }

    public function toOutputBuffer($formOrLogoutButton) {
        echo '<!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Login Example</title>
                </head>
                <body>
                    <h1>Assignment 2</h1>
                    ' . $this->displayRegisterLink() . '
                    <h2>' . $this->getLoginMessage() . '</h2>
                    <div class="container">
                        ' . $formOrLogoutButton . '
                        ' . $this->getDate() . '
                    </div>
                </body>
            </html>
        ';
    }

    public function redirect() {
        header('Location: /');
        exit();
    }

    private function getDate() {
        return $this->date->show();
    }

    private function getLoginMessage() {
        if ($this->sessionModel->getIsLoggedIn()) {
            return 'Logged in';
        } else {
            return 'Not logged in';
        }
    }

    private function displayRegisterLink() {
        if ($this->sessionModel->getIsLoggedIn()) {
            return '';
        } else {
            if ($this->isRegisterView) {
                return '<a href="/">Back to login</a>';
            } else {
                return '<a href="?register">Register a new user</a>';
            }
        }
    }
}
