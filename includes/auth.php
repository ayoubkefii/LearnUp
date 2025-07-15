<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: /login.php');
        exit();
    }
}

function require_role($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header('Location: /login.php');
        exit();
    }
}

function redirect_dashboard() {
    if (!isset($_SESSION['role'])) return;
    switch ($_SESSION['role']) {
        case 'admin':
            header('Location: /admin/dashboard.php');
            break;
        case 'instructor':
            header('Location: /instructor/dashboard.php');
            break;
        case 'student':
            header('Location: /student/dashboard.php');
            break;
    }
    exit();
}
?> 