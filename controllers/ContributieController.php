<?php
// Include het Contributie model
require_once '../../models/Contributie.php';

class ContributieController {
    private $conn;
    private $contributie;

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($conn) {
        $this->conn = $conn;
        $this->contributie = new Contributie($conn);
    }

    // Methode om een nieuwe contributie aan te maken
    public function create($leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id) {
        return $this->contributie->create($leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id);
    }

    // Methode om alle contributies op te halen
    public function readAll() {
        return $this->contributie->readAll();
    }

    // Methode om alle contributies op te halen met details
    public function readAllWithDetails() {
        return $this->contributie->readAllWithDetails();
    }

    // Methode om een contributie op te halen op basis van ID
    public function getById($id) {
        return $this->contributie->getById($id);
    }

    // Methode om een contributie bij te werken
    public function update($id, $leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id) {
        return $this->contributie->update($id, $leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id);
    }

    // Methode om een contributie te verwijderen
    public function delete($id) {
        return $this->contributie->delete($id);
    }
}
?>