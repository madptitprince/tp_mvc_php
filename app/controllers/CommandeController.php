<?php
require_once __DIR__ . '/../models/Commande.php';

class CommandeController {
    public function index() {
        $commandes = Commande::findAll();
        require_once __DIR__ . '/../views/commande/index.php';
    }

    public function show($id) {
        $commande = Commande::findById($id);
        require_once __DIR__ . '/../views/commande/show.php';
    }

    public function byClient($id_client) {
        $commandes = Commande::findByClientId($id_client);
        require_once __DIR__ . '/../views/commande/index.php';
    }
}
