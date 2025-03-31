<?php
class Client
{
    private $id;
    private $nom;
    private $email;
    private $telephone;
    private $password;

    public function __construct($id, $nom, $email, $telephone, $password = '')
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->password = $password;
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
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public static function findAll()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM clients");
        $clients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client($row['id'], $row['nom'], $row['email'], $row['telephone'], $row['password']);
        }
        return $clients;
    }

    public static function findById($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Client($row['id'], $row['nom'], $row['email'], $row['telephone'], $row['password']);
        }
        return null;
    }
    
    public static function findByEmail($email)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM clients WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Client($row['id'], $row['nom'], $row['email'], $row['telephone'], $row['password']);
        }
        return null;
    }
    
    public static function create($nom, $email, $telephone, $password)
    {
        $db = Database::getConnection();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO clients (nom, email, telephone, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $telephone, $hashed_password]);
        
        return new Client($db->lastInsertId(), $nom, $email, $telephone, $hashed_password);
    }
    
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
}
