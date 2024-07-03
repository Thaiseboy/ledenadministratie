<?php
// Include het Boekjaar model
require_once '../../models/Boekjaar.php';

class BoekjaarController {
    private $conn;
    private $boekjaar;

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($conn) {
        $this->conn = $conn;
        $this->boekjaar = new Boekjaar($conn);
    }

    // Methode om alle boekjaren op te halen
    public function readAll() {
        return $this->boekjaar->readAll();
    }

    // Methode om een boekjaar bij te werken
    public function update($id, $jaar) {
        $sql = "UPDATE boekjaar SET jaar = :jaar WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':jaar', $jaar);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "Boekjaar succesvol gewijzigd";
        } else {
            return "Fout bij boekjaar wijzigen: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Methode om een boekjaar op te halen op basis van ID
    public function getById($id) {
        $sql = "SELECT * FROM boekjaar WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Methode om een boekjaar te verwijderen
    public function delete($id) {
        $sql = "DELETE FROM boekjaar WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Methode om een nieuw boekjaar toe te voegen
    public function create($jaar) {
        $sql = "INSERT INTO boekjaar (jaar) VALUES (:jaar)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':jaar', $jaar);
        if ($stmt->execute()) {
            return "Boekjaar succesvol aangemaakt.";
        } else {
            return "Error creating record: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>