<?php
class Boekjaar {
    private $conn;
    private $table = 'boekjaar';

    public $id;
    public $jaar;

    // Constructor, initialiseer de database verbinding
    public function __construct($db) {
        $this->conn = $db;
    }

    // Maak een nieuw boekjaar aan
    public function create($jaar) {
        $query = "INSERT INTO " . $this->table . " (jaar) VALUES (:jaar)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':jaar', $jaar);

        // Voer de query uit en controleer of het succesvol was
        if ($stmt->execute()) {
            return "Boekjaar succesvol aangemaakt.";
        } else {
            return "Er is een fout opgetreden bij het aanmaken van het boekjaar.";
        }
    }

    // Haal alle boekjaren op
    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een specifiek boekjaar op op basis van ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>