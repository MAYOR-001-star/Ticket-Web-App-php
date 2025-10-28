<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

// Get ?page (default = landing)
$page = $_GET['page'] ?? 'landing';

// Allowed pages for routing
$allowed = [
    'landing',
    'login',
    'signup',
    'dashboard',
    'tickets'
];

// Security: fallback if unknown
if (!in_array($page, $allowed)) {
    $page = 'landing';
}

// Render
echo $twig->render($page . '.twig');
