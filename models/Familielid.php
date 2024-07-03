<?php
class Familielid {
    private $conn;
    private $table = 'familielid';

    public $id;
    public $naam;
    public $geboortedatum;
    public $soort_lid_id;
    public $familie_id;

    // Constructor, initialiseer de database verbinding
    public function __construct($db) {
        $this->conn = $db;
    }

    // Maak een nieuw familielid aan
    public function create($naam, $geboortedatum, $soort_lid_id, $familie_id) {
        $query = "INSERT INTO " . $this->table . " (naam, geboortedatum, soort_lid_id, familie_id) 
                  VALUES (:naam, :geboortedatum, :soort_lid_id, :familie_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':geboortedatum', $geboortedatum);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':familie_id', $familie_id);

        // Voer de query uit en controleer of het succesvol was
        if ($stmt->execute()) {
            return "Familielid succesvol aangemaakt.";
        } else {
            return "Er is een fout opgetreden bij het aanmaken van het familielid.";
        }
    }

    // Haal alle familieleden op
    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een specifiek familielid op op basis van ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>