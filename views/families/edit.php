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

// Maak een controller aan voor families
$familiesController = new FamiliesController($conn);

// Controleer of er een ID is meegegeven, anders omleiden naar de weergavepagina
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

// Haal de familie op basis van het ID
$familie = $familiesController->getById($_GET['id']);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    // Update de familie en bewaar het bericht
    $message = $familiesController->update($_GET['id'], $naam, $adres);
    header("Location: view.php?message=" . urlencode($message));
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familie Bewerken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Familie Bewerken</h1>
    </header>
    <main>
        <nav>
            <ul>
                <li><a href="../welcome.php">Dashboard</a></li>
                <li><a href="view.php">Families Bekijken</a></li>
                <li><a href="create.php">Familie Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Familie Bewerken</h2>
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="post" action="edit.php?id=<?php echo htmlspecialchars($_GET['id']); ?>">
                <div>
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam" value="<?php echo htmlspecialchars($familie['naam']); ?>"
                        required>
                </div>
                <div>
                    <label for="adres">Adres</label>
                    <input type="text" id="adres" name="adres"
                        value="<?php echo htmlspecialchars($familie['adres']); ?>" required>
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