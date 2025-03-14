<?php

// Include necessary controllers
require_once __DIR__ . '/../app/controllers/ClientController.php';
require_once __DIR__ . '/../app/controllers/CommandeController.php';
require_once __DIR__ . '/../app/controllers/ArticleController.php';
require_once __DIR__ . '/../app/core/Database.php';


// Simple router to call controllers
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page == 'clients') {
    $controller = new ClientController();
    $controller->index();
} elseif ($page == 'commandes') {
    $controller = new CommandeController();
    $controller->index();
} elseif ($page == 'articles') {
    $controller = new ArticleController();
    $controller->index();
} else {
    // Default homepage with navigation links
    echo "<h1>Welcome to My MVC Application</h1>";
    echo "<ul>
            <li><a href='?page=clients'>Clients</a></li>
            <li><a href='?page=commandes'>Commandes</a></li>
            <li><a href='?page=articles'>Articles</a></li>
          </ul>";
}
