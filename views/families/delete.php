<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();

// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/BoekjaarController.php';

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

// Maak een controller aan voor boekjaren
$boekjaarController = new BoekjaarController($conn);

// Controleer of er een ID is meegegeven, anders omleiden naar de weergavepagina
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

// Haal het boekjaar op basis van het ID
$boekjaar = $boekjaarController->getById($_GET['id']);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jaar = $_POST['jaar'];
    // Update het boekjaar en bewaar het bericht
    $message = $boekjaarController->update($_GET['id'], $jaar);
    header("Location: view.php?message=" . urlencode($message));
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boekjaar Bewerken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Boekjaar Bewerken</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="welcome.php">Dashboard</a></li>
                <li><a href="view.php">Boekjaren Bekijken</a></li>
                <li><a href="create.php">Boekjaar Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Boekjaar Bewerken</h2>
            <!-- Toon bericht na het bijwerken van een boekjaar -->
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Formulier om een bestaand boekjaar te bewerken -->
            <form method="post" action="edit.php?id=<?php echo htmlspecialchars($_GET['id']); ?>">
                <div>
                    <label for="jaar">Jaar</label>
                    <input type="text" id="jaar" name="jaar" value="<?php echo htmlspecialchars($boekjaar['jaar']); ?>"
                        required>
                </div>
                <div>
                    <button type="submit">Bijwerken</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>