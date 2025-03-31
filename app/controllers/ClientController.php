<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../core/View.php';

class ClientController {
    public function index() {
        $clients = Client::findAll();
        View::render('client/index', [
            'pageTitle' => 'Liste des clients', 
            'clients' => $clients
        ]);
    }

    public function show($id) {
        $client = Client::findById($id);
        if (!$client) {
            View::setData('flashMessage', 'Client non trouvé');
            View::setData('flashMessageType', 'danger');
            $this->index();
            return;
        }
        View::render('client/show', [
            'pageTitle' => $client->nom, 
            'client' => $client
        ]);
    }
}
