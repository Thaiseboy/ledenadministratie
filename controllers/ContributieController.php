<?php
class ContributieController {
    private $conn;

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Methode om alle contributies op te halen
    public function readAll() {
        $sql = "SELECT c.*, f.naam AS familielid_naam, b.jaar AS boekjaar_jaar 
                FROM contributie c
                JOIN familielid f ON c.familielid_id = f.id
                JOIN boekjaar b ON c.boekjaar_id = b.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Methode om alle contributies op te halen met de namen van soort leden en familielid
    public function readAllWithDetails() {
        $sql = "SELECT c.*, f.naam AS familielid_naam, s.omschrijving AS soortlid_naam, b.jaar AS boekjaar_jaar 
                FROM contributie c
                JOIN familielid f ON c.familielid_id = f.id
                JOIN soortlid s ON c.soort_lid_id = s.id
                JOIN boekjaar b ON c.boekjaar_id = b.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om een contributie bij te werken
    public function update($id, $leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id) {
        $sql = "UPDATE contributie SET leeftijd = :leeftijd, soort_lid_id = :soort_lid_id, bedrag = :bedrag, familielid_id = :familielid_id, boekjaar_id = :boekjaar_id WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':leeftijd', $leeftijd);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':bedrag', $bedrag);
        $stmt->bindParam(':familielid_id', $familielid_id);
        $stmt->bindParam(':boekjaar_id', $boekjaar_id);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "Contributie succesvol bijgewerkt.";
        } else {
            return "Error updating record: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Methode om een contributie op te halen op basis van ID
    public function getById($id) {
        $sql = "SELECT c.*, f.naam AS familielid_naam, b.jaar AS boekjaar_jaar 
                FROM contributie c
                JOIN familielid f ON c.familielid_id = f.id
                JOIN boekjaar b ON c.boekjaar_id = b.id
                WHERE c.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Methode om een contributie te verwijderen
    public function delete($id) {
        $sql = "DELETE FROM contributie WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Methode om een nieuwe contributie toe te voegen
    public function create($leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id) {
        $sql = "INSERT INTO contributie (leeftijd, soort_lid_id, bedrag, familielid_id, boekjaar_id) VALUES (:leeftijd, :soort_lid_id, :bedrag, :familielid_id, :boekjaar_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':leeftijd', $leeftijd);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':bedrag', $bedrag);
        $stmt->bindParam(':familielid_id', $familielid_id);
        $stmt->bindParam(':boekjaar_id', $boekjaar_id);
        if ($stmt->execute()) {
            return "Contributie succesvol aangemaakt.";
        } else {
            return "Error creating record: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>