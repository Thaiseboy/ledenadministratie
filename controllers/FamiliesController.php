<?php
class FamiliesController {
    private $conn;

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Methode om alle families op te halen
    public function readAll() {
        $sql = "SELECT * FROM familie";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om een familie toe te voegen
    public function create($naam, $adres) {
        $sql = "INSERT INTO familie (naam, adres) VALUES (:naam, :adres)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        if ($stmt->execute()) {
            return "Familie succesvol aangemaakt.";
        } else {
            return "Error creating record: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Methode om een familie bij te werken
    public function update($id, $naam, $adres) {
        $sql = "UPDATE familie SET naam = :naam, adres = :adres WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        if ($stmt->execute()) {
            return "Familie succesvol bijgewerkt.";
        } else {
            return "Error updating record: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Methode om een familie te verwijderen
    public function delete($id) {
        $sql = "DELETE FROM familie WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "Familie succesvol verwijderd.";
        } else {
            return "Error deleting record: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Methode om een familie op te halen op basis van ID
    public function getById($id) {
        $sql = "SELECT * FROM familie WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>