<?php
class Familie {
    private $conn;
    private $table = 'familie';

    public $id;
    public $naam;
    public $adres;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($naam, $adres) {
        $query = "INSERT INTO " . $this->table . " (naam, adres) VALUES (:naam, :adres)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        if ($stmt->execute()) {
            return "Familie succesvol aangemaakt!";
        } else {
            return "Familie aanmaken mislukt.";
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $naam, $adres) {
        $query = "UPDATE " . $this->table . " SET naam = :naam, adres = :adres WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "Familie succesvol bijgewerkt!";
        } else {
            return "Bijwerken van familie mislukt.";
        }
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "Familie succesvol verwijderd!";
        } else {
            return "Verwijderen van familie mislukt.";
        }
    }
}
?>