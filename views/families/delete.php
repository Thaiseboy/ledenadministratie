<?php
session_start();
require_once '../../config/config.php';
require_once '../../controllers/FamiliesController.php';

$familiesController = new FamiliesController($conn);

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

$message = $familiesController->delete($_GET['id']);

header("Location: view.php?message=" . urlencode($message));
exit();
?>