<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();

// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/FamilielidController.php';

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

// Maak een controller aan voor familieleden
$familielidController = new FamilielidController($conn);

// Controleer of er een ID is meegegeven, anders omleiden naar de weergavepagina
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

// Verwijder het familielid op basis van het ID
$id = $_GET['id'];
if ($familielidController->delete($id)) {
    $message = "Familielid succesvol verwijderd.";
} else {
    $message = "Er is een fout opgetreden bij het verwijderen van het familielid.";
}

header("Location: view.php?message=" . urlencode($message));
exit();
?>