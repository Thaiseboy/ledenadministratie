<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../config/config.php';
require_once '../../controllers/ContributieController.php';

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

//Maak een nieuwe ContributieController aan met de databaseverbinding
$contributieController = new ContributieController($conn);

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

//Verwijder de contributie en bewaar het bericht 
$id = $_GET['id'];
$message = $contributieController->delete($id);

// Redirect naar de view pagina met het bericht 
header("Location: view.php?message=" . urlencode($message));
exit();
?>