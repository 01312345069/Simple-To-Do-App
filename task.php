<?php
session_start();
$file = 'tasks.json';

if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

$tasks = json_decode(file_get_contents($file), true);

if (isset($_POST['task']) && $_POST['action'] == 'add') {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $tasks[] = ['name' => $task, 'done' => false];
        file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT));
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    unset($tasks[$_GET['id']]);
    $tasks = array_values($tasks);
    file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT));
} elseif (isset($_GET['action']) && $_GET['action'] == 'toggle' && isset($_GET['id'])) {
    $tasks[$_GET['id']]['done'] = !$tasks[$_GET['id']]['done'];
    file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT));
}

header("Location: index.php"); // Redirect after action
exit;