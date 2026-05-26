<?php

/**
 * User model — all SQL related to the users table lives here only.
 * Never write SQL in controllers or views.
 */
class User {

    public function __construct(private PDO $db) {}

    /**
     * Find a user by email address.
     * Used during login to look up credentials.
     */
    public function findByEmail(string $email): array|false {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Find a user by their ID.
     * Used to reload user info from the session.
     */
    public function findById(int $id): array|false {
        $stmt = $this->db->prepare('SELECT id, name, email FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create a new user account.
     * ALWAYS hashes the password with bcrypt — never stores plain text.
     */
    public function create(string $name, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password) VALUES (?, ?, ?)'
        );
        return $stmt->execute([$name, $email, $hash]);
    }
}
