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

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($db) {
        $this->conn = $db;
    }

    // Methode om een nieuwe contributie aan te maken
    public function create($leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id) {
        $query = "INSERT INTO " . $this->table . " (leeftijd, soort_lid_id, bedrag, familielid_id, boekjaar_id) VALUES (:leeftijd, :soort_lid_id, :bedrag, :familielid_id, :boekjaar_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':leeftijd', $leeftijd);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':bedrag', $bedrag);
        $stmt->bindParam(':familielid_id', $familielid_id);
        $stmt->bindParam(':boekjaar_id', $boekjaar_id);

        // Controleer of de query succesvol is uitgevoerd
        if ($stmt->execute()) {
            return "Contributie succesvol toegevoegd!";
        } else {
            return "Toevoegen van contributie mislukt.";
        }
    }

    // Methode om alle contributies op te halen
    public function readAll() {
        $query = "SELECT c.*, f.naam AS familielid_naam, b.jaar AS boekjaar_jaar 
                  FROM " . $this->table . " c
                  JOIN familielid f ON c.familielid_id = f.id
                  JOIN boekjaar b ON c.boekjaar_id = b.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om alle contributies op te halen met details
    public function readAllWithDetails() {
        $query = "SELECT c.*, f.naam AS familielid_naam, s.omschrijving AS soortlid_naam, b.jaar AS boekjaar_jaar 
                  FROM " . $this->table . " c
                  JOIN familielid f ON c.familielid_id = f.id
                  JOIN soortlid s ON c.soort_lid_id = s.id
                  JOIN boekjaar b ON c.boekjaar_id = b.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om een contributie op te halen op basis van ID
    public function getById($id) {
        $query = "SELECT c.*, f.naam AS familielid_naam, s.omschrijving AS soortlid_naam, b.jaar AS boekjaar_jaar 
                  FROM " . $this->table . " c
                  JOIN familielid f ON c.familielid_id = f.id
                  JOIN soortlid s ON c.soort_lid_id = s.id
                  JOIN boekjaar b ON c.boekjaar_id = b.id
                  WHERE c.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Methode om een contributie bij te werken
    public function update($id, $leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id) {
        $query = "UPDATE " . $this->table . " SET leeftijd = :leeftijd, soort_lid_id = :soort_lid_id, bedrag = :bedrag, familielid_id = :familielid_id, boekjaar_id = :boekjaar_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':leeftijd', $leeftijd);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':bedrag', $bedrag);
        $stmt->bindParam(':familielid_id', $familielid_id);
        $stmt->bindParam(':boekjaar_id', $boekjaar_id);
        $stmt->bindParam(':id', $id);

        // Controleer of de query succesvol is uitgevoerd
        if ($stmt->execute()) {
            return "Contributie succesvol bijgewerkt!";
        } else {
            return "Bijwerken van contributie mislukt.";
        }
    }

    // Methode om een contributie te verwijderen
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Controleer of de query succesvol is uitgevoerd
        if ($stmt->execute()) {
            return "Contributie succesvol verwijderd!";
        } else {
            return "Verwijderen van contributie mislukt.";
        }
    }
}
?>