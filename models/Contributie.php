<?php
class Contributie {
    private $conn;
    private $table = 'contributie';

    public $id;
    public $leeftijd;
    public $soort_lid_id;
    public $bedrag;
    public $familielid_id;
    public $boekjaar_id;

    // Constructor, initialiseer de database verbinding
    public function __construct($db) {
        $this->conn = $db;
    }

    // Maak een nieuwe contributie aan voor een familielid
    public function create($familielid_id, $leeftijd, $soort_lid_id, $bedrag, $boekjaar_id) {
        $query = "INSERT INTO " . $this->table . " (familielid_id, leeftijd, soort_lid_id, bedrag, boekjaar_id) 
                  VALUES (:familielid_id, :leeftijd, :soort_lid_id, :bedrag, :boekjaar_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':familielid_id', $familielid_id);
        $stmt->bindParam(':leeftijd', $leeftijd);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':bedrag', $bedrag);
        $stmt->bindParam(':boekjaar_id', $boekjaar_id);

        // Voer de query uit en controleer of het succesvol was
        if ($stmt->execute()) {
            return "Contributie succesvol aangemaakt.";
        } else {
            return "Er is een fout opgetreden bij het aanmaken van de contributie.";
        }
    }

    // Haal alle contributies op
    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal een specifieke contributie op op basis van ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>