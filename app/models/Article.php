<?php
class Article {
    private $id;
    private $nom;
    private $description;
    private $prix;

    public function __construct($id, $nom, $description, $prix) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
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
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getPrix() {
        return $this->prix;
    }

    public static function findAll() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM articles");
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = new Article($row['id'], $row['nom'], $row['description'], $row['prix']);
        }
        return $articles;
    }
    
    public static function findById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Article($row['id'], $row['nom'], $row['description'], $row['prix']);
        }
        return null;
    }
}
