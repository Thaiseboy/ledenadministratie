<?php
// Database configuratie
$servername = "localhost"; // De servernaam voor de MySQL database
$username = "root"; // De gebruikersnaam voor de MySQL database
$password = "mysql"; // Het wachtwoord voor de MySQL database
$dbname = "ledenadministratie"; // De naam van de database

try {
    // Verbinding maken met de database met behulp van PDO (PHP Data Objects)
    // Dit zorgt voor een veilige en efficiënte manier om met de database te communiceren
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Zet de PDO foutmodus op uitzondering
    // Dit zorgt ervoor dat PDO een PDOException gooit als er een fout optreedt
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Als de verbinding mislukt, geef de foutmelding weer
    // Dit helpt bij het diagnosticeren van problemen met de databaseverbinding
    echo "Verbinding mislukt: " . $e->getMessage();
}
?>