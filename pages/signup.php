<?php
session_start();

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    $_SESSION['error'] = "All fields are required";
    header("Location: /?page=signup");
    exit;
}

// Fake in-memory storage
$_SESSION['ticketapp_session'] = [
    'name' => $name,
    'email' => $email,
];

$_SESSION['stats'] = [
    'total' => 12,
    'open' => 5,
    'in_progress' => 2,
    'closed' => 5
];

header("Location: /?page=dashboard");
exit;
