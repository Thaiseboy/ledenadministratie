<?php
require_once __DIR__ . '/../models/Soortlid.php';

class SoortledenController {
    private $conn;
    private $soortlid;

    // Constructor om de databaseverbinding en Soortlid-model te initialiseren
    public function __construct($db) {
        $this->conn = $db;
        $this->soortlid = new Soortlid($this->conn);
    }

    // Methode om een nieuw soort lid aan te maken
    public function create($omschrijving) {
        return $this->soortlid->create($omschrijving);
    }

    // Methode om alle soorten leden op te halen
    public function readAll() {
        $query = "SELECT * FROM soortlid";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Methode om een soort lid op ID op te halen
    public function read($id) {
        $query = "SELECT * FROM soortlid WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>