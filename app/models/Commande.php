<?php
class Commande {
    private $id;
    private $client_id; // Changed from id_client to match database schema
    private $date_commande;

    public function __construct($id, $client_id, $date_commande) {
        $this->id = $id;
        $this->client_id = $client_id;
        $this->date_commande = $date_commande;
    }
    
    // Magic method to access private properties in views
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getClientId() {
        return $this->client_id;
    }
    
    public function getDateCommande() {
        return $this->date_commande;
    }

    public static function findAll() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM commandes");
        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = new Commande($row['id'], $row['client_id'], $row['date_commande']);
        }
        return $commandes;
    }
    
    public static function findById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM commandes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Commande($row['id'], $row['client_id'], $row['date_commande']);
        }
        return null;
    }

    public static function findByClientId($client_id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM commandes WHERE client_id = ?");
        $stmt->execute([$client_id]);
        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = new Commande($row['id'], $row['client_id'], $row['date_commande']);
        }
        return $commandes;
    }
}
