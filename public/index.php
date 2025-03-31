<?php

// Include necessary controllers
require_once __DIR__ . '/../app/controllers/ClientController.php';
require_once __DIR__ . '/../app/controllers/CommandeController.php';
require_once __DIR__ . '/../app/controllers/ArticleController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Session.php';

// Authentication check helper function
function requireLogin() {
    if (!isset($_COOKIE['session_id'])) {
        header('Location: /login');
        exit;
    }
    
    $session = Session::findById($_COOKIE['session_id']);
    if (!$session || !$session->getClientId()) {
        header('Location: /login');
        exit;
    }
    
    return $session;
}

// Simple router to call controllers
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Public routes (no authentication required)
if ($page == 'login') {
    $controller = new AuthController();
    $controller->login();
} elseif ($page == 'register') {
    $controller = new AuthController();
    $controller->register();
} elseif ($page == 'logout') {
    $controller = new AuthController();
    $controller->logout();
} 
// Protected routes (authentication required)
elseif ($page == 'clients') {
    // Require login for clients page
    requireLogin();
    
    $controller = new ClientController();
    if ($action == 'show' && !is_null($id)) {
        $controller->show($id);
    } else {
        $controller->index();
    }
} elseif ($page == 'commandes') {
    // Require login for commandes page
    requireLogin();
    
    $controller = new CommandeController();
    if ($action == 'show' && !is_null($id)) {
        $controller->show($id);
    } elseif ($action == 'by-client' && !is_null($id)) {
        $controller->byClient($id);
    } elseif ($action == 'create') {
        // Add this route for order creation
        $controller->create();
    } else {
        $controller->index();
    }
} elseif ($page == 'articles') {
    // Require login for articles page
    requireLogin();
    
    $controller = new ArticleController();
    if ($action == 'show' && !is_null($id)) {
        $controller->show($id);
    } else {
        $controller->index();
    }
} elseif ($page == 'sessions') {
    // Require login for sessions page (admin functionality)
    requireLogin();
    
    $controller = new AuthController();
    $controller->viewSessions();
} else {
    // Check if user is already logged in
    if (isset($_COOKIE['session_id'])) {
        $session = Session::findById($_COOKIE['session_id']);
        if ($session && $session->getClientId()) {
            // User is logged in, redirect to commandes
            header('Location: /commandes');
            exit;
        }
    }
    
    // Default homepage with navigation links (for non-logged in users)
    echo "<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Mon Application MVC</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
    </head>
    <body>
        <div class='container py-5'>
            <div class='text-center mb-5'>
                <h1 class='display-4'>Bienvenue sur Mon Application MVC</h1>
                <p class='lead'>Gérez vos clients, commandes et produits facilement</p>
            </div>
            
            <div class='row justify-content-center'>
                <div class='col-md-6'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='d-grid gap-3'>
                                <a href='/login' class='btn btn-primary btn-lg'>
                                    <i class='fas fa-sign-in-alt me-2'></i> Se connecter
                                </a>
                                <a href='/register' class='btn btn-outline-primary btn-lg'>
                                    <i class='fas fa-user-plus me-2'></i> S'inscrire
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";
}
