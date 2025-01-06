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
    public function create($data) {
        // Validatie van de input
        if (empty($data['leeftijd']) || empty($data['soort_lid_id']) || empty($data['bedrag'])) {
            return "Alle velden zijn verplicht.";
        }

        // Call de model-methode
        return $this->contributie->create([
            'leeftijd' => $data['leeftijd'],
            'soort_lid_id' => $data['soort_lid_id'],
            'bedrag' => $data['bedrag'],
            'familielid_id' => $data['familielid_id'] ?? null,
            'boekjaar_id' => $data['boekjaar_id'] ?? null,
        ]);
    }

    // Methode om alle contributies op te halen
    public function readAll() {
        try {
            return $this->contributie->readAll();
        } catch (Exception $e) {
            return "Fout bij het ophalen van contributies: " . $e->getMessage();
        }
    }

    // Methode om een contributie op te halen op basis van ID
    public function getById($id) {
        if (!is_numeric($id)) {
            return "Ongeldig ID.";
        }

        try {
            $result = $this->contributie->getById($id);
            if (!$result) {
                return "Geen contributie gevonden met ID $id.";
            }
            return $result;
        } catch (Exception $e) {
            return "Fout bij het ophalen van contributie: " . $e->getMessage();
        }
    }

    // Methode om een contributie bij te werken
    public function update($id, $data) {
        // Validatie van de input
        if (!is_numeric($id) || empty($data['leeftijd']) || empty($data['soort_lid_id']) || empty($data['bedrag'])) {
            return "Ongeldige invoer. Alle velden zijn verplicht.";
        }

        try {
            return $this->contributie->update($id, [
                'leeftijd' => $data['leeftijd'],
                'soort_lid_id' => $data['soort_lid_id'],
                'bedrag' => $data['bedrag'],
                'familielid_id' => $data['familielid_id'] ?? null,
                'boekjaar_id' => $data['boekjaar_id'] ?? null,
            ]);
        } catch (Exception $e) {
            return "Fout bij het bijwerken van contributie: " . $e->getMessage();
        }
    }

    // Methode om een contributie te verwijderen
    public function delete($id) {
        if (!is_numeric($id)) {
            return "Ongeldig ID.";
        }

        try {
            return $this->contributie->delete($id);
        } catch (Exception $e) {
            return "Fout bij het verwijderen van contributie: " . $e->getMessage();
        }
    }
}
?>