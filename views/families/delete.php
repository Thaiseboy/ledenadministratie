<?php
session_start();
require_once '../../config/config.php';
require_once '../../controllers/FamiliesController.php';

if(!$conn) {
    die('Geen Verbinding met de database.');
}

$familiesController = new FamiliesController($conn);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view.php message=" . urlencode("Geen geldig ID opgegeven."));
    exit();
}

$message = $familiesController->delete((int)$_Get['id']);

header("Location: view.php?message=" . urlencode($message));
exit();
?>