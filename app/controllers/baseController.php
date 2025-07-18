<?php
require_once realpath(__DIR__ . '/../../core/Token.php');
require_once realpath(__DIR__ . '/../models/User.php');
require_once realpath(__DIR__ . '/../../core/Controller.php');

class BaseController extends Controller {
    protected $user = null;

    protected function requireLogin() {
        $access_token = $_COOKIE['access_token'] ?? null;

        if (empty($access_token)) {
            $this->redirect("/auth/login");
        }

        $data = Token::decode($access_token);

        if (!$data || !isset($data['username'])) {
            $this->redirect("/auth/login");
        }

        $user = User::findByUsername($data['username']);

        if (!$user) {
            $this->redirect("/auth/login");
        }

        $this->user = $user;
        return $user;
    }

    protected function getUser() {
        if ($this->user !== null) return $this->user;

        $access_token = $_COOKIE['access_token'] ?? null;
        if (!$access_token) return null;

        $data = Token::decode($access_token);
        if (!$data || !isset($data['username'])) return null;

        return User::findByUsername($data['username']) ?? null;
    }
}
