<?php

// Include necessary controllers
require_once __DIR__ . '/../app/controllers/ClientController.php';
require_once __DIR__ . '/../app/controllers/CommandeController.php';
require_once __DIR__ . '/../app/controllers/ArticleController.php';
require_once __DIR__ . '/../app/core/Database.php';

// Simple router to call controllers
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($page == 'clients') {
    $controller = new ClientController();
    if ($action == 'show' && !is_null($id)) {
        $controller->show($id);
    } else {
        $controller->index();
    }
} elseif ($page == 'commandes') {
    $controller = new CommandeController();
    if ($action == 'show' && !is_null($id)) {
        $controller->show($id);
    } elseif ($action == 'by-client' && !is_null($id)) {
        $controller->byClient($id);
    } else {
        $controller->index();
    }
} elseif ($page == 'articles') {
    $controller = new ArticleController();
    if ($action == 'show' && !is_null($id)) {
        $controller->show($id);
    } else {
        $controller->index();
    }
} else {
    // Default homepage with navigation links - now using clean URLs
    echo "<h1>Welcome to My MVC Application</h1>";
    echo "<ul>
            <li><a href='/clients'>Clients</a></li>
            <li><a href='/commandes'>Commandes</a></li>
            <li><a href='/articles'>Articles</a></li>
          </ul>";
}
