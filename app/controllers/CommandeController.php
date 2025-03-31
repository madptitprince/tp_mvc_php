<?php
require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Session.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/CommandeArticle.php';
require_once __DIR__ . '/../core/View.php';

class CommandeController {
    private function getCurrentClientId() {
        if (isset($_COOKIE['session_id'])) {
            $session = Session::findById($_COOKIE['session_id']);
            if ($session) {
                return $session->getClientId();
            }
        }
        return null;
    }
    
    public function index() {
        $client_id = $this->getCurrentClientId();
        
        // If admin (no client ID in session), show all orders
        if (!$client_id) {
            $commandes = Commande::findAll();
        } else {
            // Otherwise show only client's orders
            $commandes = Commande::findByClientId($client_id);
            $client = Client::findById($client_id);
        }
        
        View::render('commande/index', [
            'pageTitle' => 'Liste des commandes',
            'commandes' => $commandes,
            'client' => $client ?? null
        ]);
    }

    public function show($id) {
        $commande = Commande::findById($id);
        if (!$commande) {
            View::setData('flashMessage', 'Commande non trouvée');
            View::setData('flashMessageType', 'danger');
            $this->index();
            return;
        }
        
        // Check if client is accessing their own order
        $client_id = $this->getCurrentClientId();
        if ($client_id && $commande->client_id != $client_id) {
            View::setData('flashMessage', 'Vous n\'êtes pas autorisé à voir cette commande');
            View::setData('flashMessageType', 'danger');
            $this->index();
            return;
        }
        
        // Get client data for this order
        $client = Client::findById($commande->client_id);
        
        // Get order items
        $items = CommandeArticle::findByCommandeId($commande->id);
        
        View::render('commande/show', [
            'pageTitle' => 'Commande #' . $commande->id,
            'commande' => $commande,
            'client' => $client,
            'items' => $items
        ]);
    }

    public function byClient($id_client) {
        // Check if client is accessing their own orders
        $current_client_id = $this->getCurrentClientId();
        if ($current_client_id && $current_client_id != $id_client) {
            View::setData('flashMessage', 'Vous n\'êtes pas autorisé à voir ces commandes');
            View::setData('flashMessageType', 'danger');
            $this->index();
            return;
        }
        
        $client = Client::findById($id_client);
        if (!$client) {
            View::setData('flashMessage', 'Client non trouvé');
            View::setData('flashMessageType', 'danger');
            $this->index();
            return;
        }
        
        $commandes = Commande::findByClientId($id_client);
        View::render('commande/index', [
            'pageTitle' => 'Commandes de ' . $client->nom,
            'commandes' => $commandes,
            'client' => $client
        ]);
    }
    
    public function create() {
        $client_id = $this->getCurrentClientId();
        $error = null;
        $success = null;
        
        // Get all available articles for the order form
        $articles = Article::findAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate inputs
            $articleIds = $_POST['article_ids'] ?? [];
            $quantities = $_POST['quantities'] ?? [];
            
            if (empty($articleIds)) {
                $error = "Veuillez sélectionner au moins un article";
            } else {
                try {
                    // Create new order
                    $commande = Commande::create($client_id);
                    
                    // Add articles to the order
                    foreach ($articleIds as $index => $article_id) {
                        if (isset($quantities[$index]) && $quantities[$index] > 0) {
                            CommandeArticle::create(
                                $commande->getId(),
                                $article_id,
                                $quantities[$index]
                            );
                        }
                    }
                    
                    $success = "Commande créée avec succès!";
                    
                    // Redirect to the new order
                    header("Location: /commandes/show/" . $commande->getId());
                    exit;
                    
                } catch (Exception $e) {
                    $error = "Erreur lors de la création de la commande: " . $e->getMessage();
                }
            }
        }
        
        View::render('commande/create', [
            'pageTitle' => 'Nouvelle Commande',
            'articles' => $articles,
            'error' => $error,
            'success' => $success
        ]);
    }
}
