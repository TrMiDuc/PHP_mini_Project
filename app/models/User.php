<?php
    require_once realpath(__DIR__ . '/../../core/Model.php');

    class User extends Model {
        private $id;
        private $username;

        public function __construct($id, $username) {
            $this->id = $id;
            $this->username = $username;
        }

        public function getID() {
            return $this->id;
        }

        public function getUsername() {
            return $this->username;
        }

        public static function findByUsername($username) {
            $result = self::doQuery(
                "SELECT id, username FROM users WHERE username = ?",
                's',
                [$username],
                'User found.',
                'User not found.'
            );
            if ($result['success'] && !empty($result['data'])) {
                return new self($result['data'][0]['id'], $result['data'][0]['username']);
            }
            return null;
        }

        public static function login($username, $password) {
            $result = self::doQuery(
                "SELECT id, username, password FROM users WHERE username = ?",
                's',
                [$username],
                'User lookup successful.',
                'User not found.'
            );

            if ($result['success'] && !empty($result['data'])) {
                $user = $result['data'][0];
                if (password_verify($password, $user['password'])) {
                    return new self($user['id'], $user['username']);
                }
            }

            return null;
        }

        public static function signup($username, $password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = self::doQuery(
                "INSERT INTO users (username, password) VALUES (?, ?)",
                'ss',
                [$username, $hashedPassword],
                'User created successfully.',
                'User creation failed.'
            );
            return $result['success'] ? ['success'=> true, 'message' => $result['message']] : null;
        }
    }      
?>