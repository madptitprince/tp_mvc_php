<?php
class CommandeArticle {
    private $id;
    private $commande_id;
    private $article_id;
    private $quantite;
    private $prix_unitaire;

    public function __construct($id, $commande_id, $article_id, $quantite, $prix_unitaire) {
        $this->id = $id;
        $this->commande_id = $commande_id;
        $this->article_id = $article_id;
        $this->quantite = $quantite;
        $this->prix_unitaire = $prix_unitaire;
    }
    
    // Magic method to access private properties in views
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
    
    public static function create($commande_id, $article_id, $quantite) {
        $db = Database::getConnection();
        
        // Get the current price of the article
        $stmt = $db->prepare("SELECT prix FROM articles WHERE id = ?");
        $stmt->execute([$article_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $prix_unitaire = $row ? $row['prix'] : 0;
        
        // Insert into commande_articles
        $stmt = $db->prepare("INSERT INTO commande_articles (commande_id, article_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$commande_id, $article_id, $quantite, $prix_unitaire]);
        
        $id = $db->lastInsertId();
        return new CommandeArticle($id, $commande_id, $article_id, $quantite, $prix_unitaire);
    }
    
    public static function findByCommandeId($commande_id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT ca.*, a.nom as article_nom, a.description as article_description 
                              FROM commande_articles ca 
                              LEFT JOIN articles a ON ca.article_id = a.id 
                              WHERE ca.commande_id = ?");
        $stmt->execute([$commande_id]);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new CommandeArticle($row['id'], $row['commande_id'], $row['article_id'], $row['quantite'], $row['prix_unitaire']);
            $item->article_nom = $row['article_nom'];
            $item->article_description = $row['article_description'];
            $items[] = $item;
        }
        return $items;
    }
}