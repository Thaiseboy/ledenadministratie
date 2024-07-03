<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../config/config.php';
require_once '../../controllers/BoekjaarController.php';

// Maak een nieuwe BoekjaarController aan met de database verbinding
$boekjaarController = new BoekjaarController($conn);

// Controleer of er een ID is meegegeven
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

$id = $_GET['id'];
// Verwijder het boekjaar en bewaar het bericht
$message = $boekjaarController->delete($id);

// Redirect naar de view pagina met het bericht
header("Location: view.php?message=" . urlencode($message));
exit();
?>