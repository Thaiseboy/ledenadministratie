<?php
class Contributie {
    private $conn;
    private $table = 'contributie';

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($db) {
        $this->conn = $db;
    }

    // Methode om een nieuwe contributie aan te maken
    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      (leeftijd, soort_lid_id, bedrag, familielid_id, boekjaar_id) 
                      VALUES (:leeftijd, :soort_lid_id, :bedrag, :familielid_id, :boekjaar_id)";
            $stmt = $this->conn->prepare($query);

            // Parameters binden
            $stmt->bindParam(':leeftijd', $data['leeftijd']);
            $stmt->bindParam(':soort_lid_id', $data['soort_lid_id']);
            $stmt->bindParam(':bedrag', $data['bedrag']);
            $stmt->bindParam(':familielid_id', $data['familielid_id']);
            $stmt->bindParam(':boekjaar_id', $data['boekjaar_id']);

            // Query uitvoeren
            $stmt->execute();
            return "Contributie succesvol toegevoegd!";
        } catch (PDOException $e) {
            return "Fout bij het toevoegen van contributie: " . $e->getMessage();
        }
    }

    // Methode om alle contributies op te halen
    public function readAll() {
        try {
            $query = "SELECT c.*, f.naam AS familielid_naam, s.omschrijving AS soortlid_naam, b.jaar AS boekjaar_jaar 
                      FROM " . $this->table . " c
                      JOIN familielid f ON c.familielid_id = f.id
                      JOIN soortlid s ON c.soort_lid_id = s.id
                      JOIN boekjaar b ON c.boekjaar_id = b.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Fout bij het ophalen van contributies: " . $e->getMessage();
        }
    }

    // Methode om een specifieke contributie op te halen op basis van ID
    public function getById($id) {
        try {
            $query = "SELECT c.*, f.naam AS familielid_naam, s.omschrijving AS soortlid_naam, b.jaar AS boekjaar_jaar 
                      FROM " . $this->table . " c
                      JOIN familielid f ON c.familielid_id = f.id
                      JOIN soortlid s ON c.soort_lid_id = s.id
                      JOIN boekjaar b ON c.boekjaar_id = b.id
                      WHERE c.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Fout bij het ophalen van contributie: " . $e->getMessage();
        }
    }

    // Methode om een contributie bij te werken
    public function update($id, $data) {
        try {
            $query = "UPDATE " . $this->table . " 
                      SET leeftijd = :leeftijd, 
                          soort_lid_id = :soort_lid_id, 
                          bedrag = :bedrag, 
                          familielid_id = :familielid_id, 
                          boekjaar_id = :boekjaar_id 
                      WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            // Parameters binden
            $stmt->bindParam(':leeftijd', $data['leeftijd']);
            $stmt->bindParam(':soort_lid_id', $data['soort_lid_id']);
            $stmt->bindParam(':bedrag', $data['bedrag']);
            $stmt->bindParam(':familielid_id', $data['familielid_id']);
            $stmt->bindParam(':boekjaar_id', $data['boekjaar_id']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Query uitvoeren
            if ($stmt->execute()) {
                return "Contributie succesvol bijgewerkt!";
            }
            return "Bijwerken van contributie mislukt.";
        } catch (PDOException $e) {
            return "Fout bij het bijwerken van contributie: " . $e->getMessage();
        }
    }

    // Methode om een contributie te verwijderen
    public function delete($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Query uitvoeren
            if ($stmt->execute()) {
                return "Contributie succesvol verwijderd!";
            }
            return "Verwijderen van contributie mislukt.";
        } catch (PDOException $e) {
            return "Fout bij het verwijderen van contributie: " . $e->getMessage();
        }
    }
}
?>