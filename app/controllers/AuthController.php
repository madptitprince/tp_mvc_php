<?php
// filepath: /home/adiack/Documents/3a_sti/semestre2/ingénierie_web/tp1/new1/tp_mvc_php/app/controllers/AuthController.php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Session.php';
require_once __DIR__ . '/../core/View.php';

class AuthController {
    public function login() {
        // Check if already logged in
        if (isset($_COOKIE['session_id'])) {
            $session = Session::findById($_COOKIE['session_id']);
            if ($session && $session->getClientId()) {
                header('Location: /commandes');
                exit;
            }
        }
        
        $error = null;
        
        // Process login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $client = Client::findByEmail($email);
            
            if ($client && $client->verifyPassword($password)) {
                // Login successful, create new session
                $session = Session::create($client->getId());
                
                // Set HttpOnly to false to make cookie visible in DevTools
                setcookie('session_id', $session->getId(), [
                    'expires' => time() + 86400,
                    'path' => '/',
                    'domain' => '',
                    'secure' => false,
                    'httponly' => false,
                    'samesite' => 'Lax'
                ]);
                
                header('Location: /commandes');
                exit;
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        }
        
        View::render('auth/login', [
            'pageTitle' => 'Connexion',
            'error' => $error
        ]);
    }
    
    public function register() {
        $error = null;
        
        // Process registration form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Basic validation
            if (empty($nom) || empty($email) || empty($password)) {
                $error = 'Tous les champs sont obligatoires';
            } elseif ($password !== $confirm_password) {
                $error = 'Les mots de passe ne correspondent pas';
            } elseif (Client::findByEmail($email)) {
                $error = 'Cette adresse email est déjà utilisée';
            } else {
                // Create new client
                $client = Client::create($nom, $email, $telephone, $password);
                
                // Create session and log in
                $session = Session::create($client->getId());
                
                // Set HttpOnly to false to make cookie visible in DevTools
                setcookie('session_id', $session->getId(), [
                    'expires' => time() + 86400,
                    'path' => '/',
                    'domain' => '',
                    'secure' => false,
                    'httponly' => false,
                    'samesite' => 'Lax'
                ]);
                
                header('Location: /commandes');
                exit;
            }
        }
        
        View::render('auth/register', [
            'pageTitle' => 'Inscription',
            'error' => $error
        ]);
    }
    
    public function logout() {
        if (isset($_COOKIE['session_id'])) {
            Session::destroy($_COOKIE['session_id']);
            
            // Clear the cookie
            setcookie('session_id', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'domain' => '',
                'secure' => false,
                'httponly' => false,
                'samesite' => 'Lax'
            ]);
        }
        
        header('Location: /');
        exit;
    }
    
    // Add a method to view all active sessions
    public function viewSessions() {
        // Check if user is admin
        // This is a simple example - you should implement proper admin authentication
        
        $sessions = Session::getAllActive();
        
        View::render('auth/sessions', [
            'pageTitle' => 'Active Sessions',
            'sessions' => $sessions
        ]);
    }
}