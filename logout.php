<?php
session_start(); // Start de sessie
session_destroy(); // Vernietig alle sessiegegevens
header("Location: index.php"); // Stuur de gebruiker terug naar de hoofdpagina
exit(); // Zorg ervoor dat er geen verdere code wordt uitgevoerd
?>