<?php
class FamilielidController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Methode om alle familieleden op te halen
    public function readAll() {
        $sql = "SELECT * FROM familielid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om alle soorten leden op te halen
    public function readAllSoortlid() {
        $sql = "SELECT * FROM soortlid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Methode om alle familieleden op te halen met de namen van hun families
    public function readAllWithFamilyNames() {
        $sql = "SELECT familielid.*, familie.naam AS familie_naam
                FROM familielid
                JOIN familie ON familielid.familie_id = familie.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // Methode om alle familieleden op te halen met de namen van hun families en soort lid
        public function readAllWithDetails() {
        $sql = "SELECT familielid.*, familie.naam AS familie_naam, soortlid.omschrijving AS soortlid_naam
                FROM familielid
                JOIN familie ON familielid.familie_id = familie.id
                JOIN soortlid ON familielid.soort_lid_id = soortlid.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om een familielid bij te werken
    public function update($id, $naam, $geboortedatum, $soort_lid_id, $familie_id) {
        $sql = "UPDATE familielid SET naam = :naam, geboortedatum = :geboortedatum, soort_lid_id = :soort_lid_id, familie_id = :familie_id WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':geboortedatum', $geboortedatum);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':familie_id', $familie_id);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "Familielid is gewijzigd";
        } else {
            return "Error updating record: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Methode om een familielid op te halen op basis van ID
    public function getById($id) {
        $sql = "SELECT * FROM familielid WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Methode om een familielid te verwijderen
    public function delete($id) {
        $sql = "DELETE FROM familielid WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Methode om een nieuw familielid toe te voegen
    public function create($naam, $geboortedatum, $soort_lid_id, $familie_id) {
        $sql = "INSERT INTO familielid (naam, geboortedatum, soort_lid_id, familie_id) VALUES (:naam, :geboortedatum, :soort_lid_id, :familie_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':geboortedatum', $geboortedatum);
        $stmt->bindParam(':soort_lid_id', $soort_lid_id);
        $stmt->bindParam(':familie_id', $familie_id);
        if ($stmt->execute()) {
            return "Familielid succesvol aangemaakt.";
        } else {
            return "Error creating record: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>