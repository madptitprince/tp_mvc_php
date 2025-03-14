<?php

// Parse the URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static files directly
$staticExtensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'ico'];
$extension = pathinfo($uri, PATHINFO_EXTENSION);
if (in_array($extension, $staticExtensions)) {
    // Check if file exists in public folder
    $file = __DIR__ . $uri;
    if (file_exists($file)) {
        // Set correct content type
        switch ($extension) {
            case 'css': header('Content-Type: text/css'); break;
            case 'js': header('Content-Type: application/javascript'); break;
            case 'jpg':
            case 'jpeg': header('Content-Type: image/jpeg'); break;
            case 'png': header('Content-Type: image/png'); break;
            case 'gif': header('Content-Type: image/gif'); break;
            case 'ico': header('Content-Type: image/x-icon'); break;
        }
        readfile($file);
        return true;
    }
}

// Parse URL to extract parameters
$parts = explode('/', trim($uri, '/'));
$page = isset($parts[0]) && !empty($parts[0]) ? $parts[0] : 'home';
$action = isset($parts[1]) && !empty($parts[1]) ? $parts[1] : 'index';
$id = isset($parts[2]) && !empty($parts[2]) ? (int)$parts[2] : null;

// Set $_GET values to maintain compatibility with existing code
$_GET['page'] = $page;
if ($action !== 'index') $_GET['action'] = $action;
if ($id !== null) $_GET['id'] = $id;

// Include the main application entry point
require __DIR__ . '/index.php';