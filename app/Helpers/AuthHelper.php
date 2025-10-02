<?php
// app/helpers/authHelper.php

// Start the session if it’s not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if a user is logged in.
 *
 * @return bool
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Get the currently logged-in user's ID.
 *
 * @return int|null
 */
function currentUserId(): ?int {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get the currently logged-in user's username.
 *
 * @return string|null
 */
function currentUsername(): ?string {
    return $_SESSION['username'] ?? null;
}

/**
 * Require login before accessing a page.
 * Redirects to login if user is not logged in.
 */
function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: ' . URLROOT . '/views/auth/login.php');
        exit;
    }
}

/**
 * Redirect user to their dashboard/homepage if already logged in.
 * Useful to prevent logged-in users from seeing the login/signup page again.
 */
function redirectIfLoggedIn(): void {
    if (isLoggedIn()) {
        header('Location: ' . URLROOT . '/views/user/homepage.php');
        exit;
    }
}

/**
 * Log the user out and destroy session.
 */
function logout(): void {
    $_SESSION = [];
    session_destroy();
    header('Location: ' . URLROOT . '/views/auth/login.php');
    exit;
}
