<?php

require_once __DIR__ . '/../models/User.php';

// AuthController — handles register, login, and logout.
class AuthController {

    private User $user;

    public function __construct() {
        $this->user = new User(getDB());
    }

    // =LOGIN=
    // GET  /login  → show the login form
    // POST /login  → validate credentials and start session
    public function login(): void {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $pass  = $_POST['password'] ?? '';

            // Server-side validation (Dynamic Feature #3)
            if (!$email || !$pass) {
                $error = 'All fields are required.';
            } else {
                $found = $this->user->findByEmail($email);
                if ($found && password_verify($pass, $found['password'])) {
                    session_regenerate_id(true); // prevent session fixation attack
                    $_SESSION['user_id'] = $found['id'];
                    $_SESSION['name']    = $found['name'];
                    header('Location: /');
                    exit;
                }
                $error = 'Invalid email or password.';
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    // =REGISTER=
    // GET  /register → show the registration form
    // POST /register → validate input and create account
    public function register(): void {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name  = trim($_POST['name']     ?? '');
            $email = trim($_POST['email']    ?? '');
            $pass  = $_POST['password']      ?? '';
            $conf  = $_POST['confirm']       ?? '';

            // Validation chain
            if (!$name || !$email || !$pass || !$conf) {
                $error = 'All fields are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif (strlen($pass) < 8) {
                $error = 'Password must be at least 8 characters.';
            } elseif ($pass !== $conf) {
                $error = 'Passwords do not match.';
            } elseif ($this->user->findByEmail($email)) {
                $error = 'That email is already registered.';
            } else {
                $this->user->create($name, $email, $pass);
                header('Location: /login');
                exit;
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    // =LOG-OUT=
    // POST /logout → destroy session and redirect
    public function logout(): void {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
