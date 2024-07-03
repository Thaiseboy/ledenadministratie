<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();
// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/FamiliesController.php';

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

// Maak een nieuwe FamiliesController aan met de database verbinding
$familiesController = new FamiliesController($conn);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    // Maak een nieuwe familie aan en bewaar het bericht
    $message = $familiesController->create($naam, $adres);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familie Toevoegen</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Familie Toevoegen</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="view.php">Families Bekijken</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Nieuwe Familie Toevoegen</h2>
            <!-- Toon bericht na het aanmaken van een familie -->
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Formulier om een nieuwe familie toe te voegen -->
            <form method="post" action="create.php">
                <div>
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam" required>
                </div>
                <div>
                    <label for="adres">Adres</label>
                    <input type="text" id="adres" name="adres" required>
                </div>
                <div>
                    <button type="submit">Toevoegen</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>