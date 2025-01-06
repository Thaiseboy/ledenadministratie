<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();

// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/helper.php'; 
require_once '../../controllers/ContributieController.php';
require_once '../../controllers/FamilielidController.php';
require_once '../../controllers/BoekjaarController.php';

// Controleer de databaseverbinding
if (!$conn) {
    die("Geen verbinding met de database");
}

// Maak controllers aan voor contributies, boekjaren en familieleden
$contributieController = new ContributieController($conn);
$boekjaarController = new BoekjaarController($conn);
$familielidController = new FamilielidController($conn);

// Haal alle familieleden en boekjaren op voor de dropdowns
$familieleden = $familielidController->readAll();
$boekjaren = $boekjaarController->readAll();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $familielid_id = sanitize($_POST['familielid_id']);
    $boekjaar_id = sanitize($_POST['boekjaar_id']);

    // Controleer of de invoer geldig is
    if (empty($familielid_id) || empty($boekjaar_id)) {
        $message = "Alle velden zijn verplicht.";
        redirectWithMessage('create.php', $message);
    }

    // Haal familielid en boekjaar op uit de database
    $familielid = $familielidController->getById($familielid_id);
    $boekjaar = $boekjaarController->getById($boekjaar_id);

    if (!$familielid) {
        $message = "Ongeldig familielid geselecteerd.";
        redirectWithMessage('create.php', $message);
    }

    if (!$boekjaar) {
        $message = "Ongeldig boekjaar geselecteerd.";
        redirectWithMessage('create.php', $message);
    }

    // Bereken leeftijd op basis van geboortedatum
    $geboortedatum = new DateTime($familielid['geboortedatum']);
    $huidigeDatum = new DateTime();
    $leeftijd = $huidigeDatum->diff($geboortedatum)->y;

    // Bereken soort lid en contributiebedrag met helperfunctie
    $berekening = bepaalContributie($leeftijd);
    $soort_lid_id = $berekening['soort_lid_id'];
    $bedrag = 100 * (1 - $berekening['korting']); // Basisbedrag met korting

    // Voeg contributie toe via de controller
    $message = $contributieController->create([
        'leeftijd' => $leeftijd,
        'soort_lid_id' => $soort_lid_id,
        'bedrag' => $bedrag,
        'familielid_id' => $familielid_id,
        'boekjaar_id' => $boekjaar_id,
    ]);

    // Redirect naar de overzichtspagina met een succesbericht
    redirectWithMessage('view.php', $message);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributie Toevoegen</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Contributie Toevoegen</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="view.php">Contributies Bekijken</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Contributie Toevoegen</h2>
            <!-- Toon bericht na het toevoegen van een contributie -->
            <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <!-- Formulier om een nieuwe contributie toe te voegen -->
            <form method="post" action="create.php">
                <div>
                    <label for="familielid_id">Familielid</label>
                    <select id="familielid_id" name="familielid_id" required>
                        <option value="">Selecteer een familielid</option>
                        <?php foreach ($familieleden as $familielid): ?>
                        <option value="<?php echo sanitize($familielid['id']); ?>">
                            <?php echo sanitize($familielid['naam']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="boekjaar_id">Boekjaar</label>
                    <select id="boekjaar_id" name="boekjaar_id" required>
                        <option value="">Selecteer een boekjaar</option>
                        <?php foreach ($boekjaren as $boekjaar): ?>
                        <option value="<?php echo sanitize($boekjaar['id']); ?>">
                            <?php echo sanitize($boekjaar['jaar']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
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