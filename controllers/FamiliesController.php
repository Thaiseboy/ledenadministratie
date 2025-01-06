<?php
class FamiliesController {
    private $model;

    public function __construct($conn) {
        $this->model = new Familie($conn); // Verbind het model
    }

    public function index() {
        return $this->model->getAll(); // Retourneer alle families
    }

    public function create($data) {
        if (isset($data['naam']) && isset($data['adres'])) {
            $success = $this->model->create($data['naam'], $data['adres']);
            if ($success) {
                return "Familie succesvol toegevoegd!";
            } else {
                return "Fout bij het aanmaken van familie.";
            }
        } else {
            return "Vul alle velden in.";
        }
    }

    public function edit($id, $data) {
        // Controleer of de invoer compleet is
        if (isset($data['naam']) && isset($data['adres'])) {
            // Probeer de update uit te voeren via het model
            $success = $this->model->update($id, $data['naam'], $data['adres']);
            
            // Retourneer een bericht gebaseerd op het resultaat
            if ($success) {
                return "Familie succesvol bijgewerkt!";
            } else {
                return "Fout bij het bijwerken van familie.";
            }
        } else {
            return "Vul alle velden in.";
        }
    }

    public function delete($id) {
        // Controleer of het ID betstaat
        $familie = $this->model->getById($id);
        if (!$familie) {
            return "Familie met ID $id bestaat niet.";
        }

        // Probeer familie te verwijderen
        $success = $this->model->delete($id);
        if ($success) {
            return "Familie succesvol verwijdert";
        } else {
            return "Fout bij het verwijeren van de familie";
        }
    }

    public function show($id) {
        return $this->model->getById($id); // Retourneer de gegevens van één familie
    }
}