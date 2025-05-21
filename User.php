<?php
require_once 'Database.php';

class User {
    private PDO $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function register(string $username, string $email, string $password): bool {
        if ($this->exists($username, $email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $success = $stmt->execute([$username, $email, $hashedPassword]);

        if ($success) {
            $userId = $this->db->lastInsertId();
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
        }

        return $success;
    }

    public function exists(string $username, string $email): bool {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->fetch() !== false;
    }

    public function login(string $username, string $password): bool {
        $stmt = $this->db->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            return true;
        }

        return false;
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public function logout(): void {
        session_unset();
        session_destroy();
    }
}
