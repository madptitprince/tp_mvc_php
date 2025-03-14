<?php
class Client
{
    private $id;
    private $nom;
    private $email;
    private $telephone;

    public function __construct($id, $nom, $email, $telephone)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->telephone = $telephone;
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
            $clients[] = new Client($row['id'], $row['nom'], $row['email'], $row['telephone']);
        }
        return $clients;
    }
}
