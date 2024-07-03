<?php
class Soortlid {
    private $conn;
    private $table = 'soortlid';

    public $id;
    public $omschrijving;

    // Constructor, initialiseer de database verbinding
    public function __construct($db) {
        $this->conn = $db;
    }

    // Maak een nieuw soort lid aan
    public function create($omschrijving) {
        $query = "INSERT INTO " . $this->table . " (omschrijving) VALUES (:omschrijving)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':omschrijving', $omschrijving);

        // Voer de query uit en controleer of het succesvol was
        if ($stmt->execute()) {
            return "Soort lid succesvol aangemaakt.";
        } else {
            return "Er is een fout opgetreden bij het aanmaken van het soort lid.";
        }
    }

    // Haal alle soorten leden op
    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een specifiek soort lid op op basis van ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>