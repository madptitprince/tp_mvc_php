<?php
require_once __DIR__ . '/../models/Client.php';

class ClientController {
    public function index() {
        $clients = Client::findAll();
        require_once __DIR__ . '/../views/client/index.php';
    }

    public function show($id) {
        $client = Client::findById($id);
        require_once __DIR__ . '/../views/client/show.php';
    }
}
