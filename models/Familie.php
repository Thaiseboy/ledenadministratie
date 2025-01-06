<?php
class Familie {
    private $conn;
    private $table = 'familie';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($naam, $adres) {
        $query = "INSERT INTO {$this->table} (naam, adres) VALUES (:naam, :adres)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $naam, $adres) {
        $query = "UPDATE {$this->table} SET naam = :naam, adres = :adres WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}