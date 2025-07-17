<?php
require_once realpath(__DIR__ . '/../../core/Controller.php');
require_once realpath(__DIR__ . '/../../core/Token.php');

class PageController extends Controller {

    public function index() {
        $username = 'Guest';

        $access_token = $_COOKIE['access_token'] ?? null;

        if ($access_token) {
            $payload = Token::decode($access_token);

            if ($payload && isset($payload['username'])) {
                $username = $payload['username'];
            }
        }

        $data = [
            'username' => $username
        ];

        $this->render('posts/index', $data);
    }
}
