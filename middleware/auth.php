<?php

/**
 * Authentication middleware.
 *
 * Call requireAuth() at the top of any controller method that needs a logged-in user.
 * If no session exists, the user is redirected to /login immediately.
 *
 * This is Dynamic Feature #1: Session-based authentication guard.
 */
function requireAuth(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
}
