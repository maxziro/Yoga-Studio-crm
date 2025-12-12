<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    private $db;
    private $user;

    public function __construct($db)
    {
        $this->db = $db;
        $this->user = new User($db);
    }

    public function login()
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $this->user->email = $email;

        if ($this->user->emailExists() && $this->user->verifyPassword($password)) {
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['user_name'] = $this->user->name;
            $_SESSION['user_role'] = $this->user->role;

            header("Location: /dashboard");
        } else {
            $error = "Credenziali non valide.";
            require_once __DIR__ . '/../Views/auth/login.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
    }
}
