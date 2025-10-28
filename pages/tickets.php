<?php
session_start();

/** Boot session storage */
if (!isset($_SESSION['tickets'])) {
    $_SESSION['tickets'] = [];
}

$tickets = $_SESSION['tickets'];

// ADD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $tickets[] = [
        'id' => time(),
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'status' => $_POST['status'],
        'createdAt' => date('Y-m-d H:i:s')
    ];

    $_SESSION['tickets'] = $tickets;
    header('Location: ?page=tickets');
    exit;
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($tickets as &$t) {
        if ($t['id'] == $_POST['ticket_id']) {
            $t['title'] = $_POST['title'];
            $t['description'] = $_POST['description'];
            $t['status'] = $_POST['status'];
        }
    }

    $_SESSION['tickets'] = $tickets;
    header('Location: ?page=tickets');
    exit;
}

// DELETE CONFIRM POPUP
if (isset($_GET['delete'])) {
    $_SESSION['delete_target'] = $_GET['delete'];
}

// FINAL DELETE
if (isset($_GET['confirm_delete'])) {
    $id = $_SESSION['delete_target'];

    $tickets = array_filter($tickets, fn ($t) => $t['id'] != $id);

    $_SESSION['tickets'] = $tickets;
    unset($_SESSION['delete_target']);

    header('Location: ?page=tickets');
    exit;
}

// EDIT MODE
$editTicket = null;
if (isset($_GET['edit'])) {
    foreach ($tickets as $t) {
        if ($t['id'] == $_GET['edit']) {
            $editTicket = $t;
        }
    }
}

// Put into session-global for Twig access
$_SESSION['tickets'] = $tickets;
$_SESSION['editTicket'] = $editTicket;

header('Location: ?page=tickets');
exit;
