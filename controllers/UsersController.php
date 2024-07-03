<?php
require_once __DIR__ . '/../models/User.php';

class UsersController {
    private $conn;
    private $user;

    // Constructor om de databaseverbinding en User-model te initialiseren
    public function __construct($db) {
        $this->conn = $db;
        $this->user = new User($this->conn);
    }

    //Methode voor gebruikerslogin
    public function login($username, $password) {
        $user = $this->user->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }

    // Methode om een nieuwe gebruiker aan te maken 
    public function register($username, $email, $password) {
        return $this->user->create($username, $email, $password);
    }
}
?>