<?php
// filepath: /home/adiack/Documents/3a_sti/semestre2/ingénierie_web/tp1/new1/tp_mvc_php/app/models/Session.php
class Session {
    private $id;
    private $client_id;
    private $data;
    private $expires_at;

    public function __construct($id, $client_id, $data, $expires_at) {
        $this->id = $id;
        $this->client_id = $client_id;
        $this->data = $data;
        $this->expires_at = $expires_at;
    }

    public static function create($client_id, $data = null, $expires_in = 86400) {
        $db = Database::getConnection();
        $id = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', time() + $expires_in);
        $data_json = $data ? json_encode($data) : null;

        $stmt = $db->prepare("INSERT INTO sessions (id, client_id, data, expires_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $client_id, $data_json, $expires_at]);
        
        return new Session($id, $client_id, $data, $expires_at);
    }

    public static function findById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM sessions WHERE id = ? AND expires_at > NOW()");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $data = $row['data'] ? json_decode($row['data'], true) : null;
            return new Session($row['id'], $row['client_id'], $data, $row['expires_at']);
        }
        return null;
    }

    public static function update($id, $data) {
        $db = Database::getConnection();
        $data_json = json_encode($data);
        
        $stmt = $db->prepare("UPDATE sessions SET data = ? WHERE id = ?");
        $stmt->execute([$data_json, $id]);
    }
    
    public static function destroy($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function gc() {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM sessions WHERE expires_at < NOW()");
        $stmt->execute();
    }

    public static function getAllActive() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT sessions.*, clients.nom, clients.email 
                           FROM sessions 
                           LEFT JOIN clients ON sessions.client_id = clients.id 
                           WHERE sessions.expires_at > NOW()
                           ORDER BY sessions.created_at DESC");
        
        $sessions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data = $row['data'] ? json_decode($row['data'], true) : null;
            $sessions[] = [
                'id' => $row['id'],
                'client_id' => $row['client_id'],
                'client_name' => $row['nom'] ?? 'Unknown',
                'client_email' => $row['email'] ?? 'Unknown',
                'data' => $data,
                'created_at' => $row['created_at'],
                'expires_at' => $row['expires_at']
            ];
        }
        return $sessions;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getClientId() {
        return $this->client_id;
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function getExpiresAt() {
        return $this->expires_at;
    }
}