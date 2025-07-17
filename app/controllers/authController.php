<?php
require_once realpath(__DIR__. '/../../core/Token.php');            
require_once realpath(__DIR__. '/../../app/models/User.php');
require_once realpath(__DIR__. '/../../core/Controller.php');

class AuthController extends Controller {
    private $access_token;

    public function __construct($access_token = null) {
        $this->access_token = $access_token;
    }

    public function login_token() {
        if (empty($this->access_token)) {
            $this->redirect("auth/login");
        }

        $data = Token::decode($this->access_token);

        if (!$data || !isset($data['username'])) {
            $this->redirect("auth/login");
        }

        $user = User::findByUsername($data['username']);

        if (!$user) {
            $this->redirect("auth/login");
        }

        return $user;
    }

    public function handleLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']) && $_POST['remember'] === 'on';

        $user = User::login($username, $password);
        if (!$user) {
            $this->render('auth/login', ['message' => 'Wrong username or password.']);
            return;
        }

        $token = Token::create([
            'username' => $user->getUsername()
        ], $remember ? (86400 * 3) : 3600); 

        setcookie(
            "access_token",
            $token,
            $remember ? time() + (86400 * 3) : 0,
            "/",
            "",               
            true,             
            true              
        );

        $this->redirect('/');
    }

    public function handleSignup() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if ($password !== $confirmPassword) {
            $this->render('auth/signup', ['message' => 'Passwords do not match.']);
            return;
        }

        if (User::findByUsername($username)) {
            $this->render('auth/signup', ['message' => 'Username already exists.']);
            return;
        }

        $created = User::signup($username, $password);

        if (!$created || !isset($created['success']) || !$created['success']) {
            $this->render('auth/signup', ['message' => 'Failed to create user.']);
            return;
        }

        $this->redirect('/auth/login');
    }

    public function showLogin() {
        $this->render('auth/login');
    }

    public function showSignup() {
        $this->render('auth/signup');
    }

    public function logout() {
        setcookie("access_token", "", time() - 3600, "/");
        $this->redirect('/');
    }
}