<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();

// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/ContributieController.php';
require_once '../../controllers/FamilielidController.php';
require_once '../../controllers/BoekjaarController.php';

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

// Maak controllers aan voor contributies, boekjaren en familieleden
$contributieController = new ContributieController($conn);
$boekjaarController = new BoekjaarController($conn);
$familielidController = new FamilielidController($conn);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $familielid_id = $_POST['familielid_id'];
    $boekjaar_id = $_POST['boekjaar_id'];
    // Bereken de leeftijd en soort lid automatisch
    $familielid = $familielidController->getById($familielid_id);
    $geboortedatum = new DateTime($familielid['geboortedatum']);
    $huidigeDatum = new DateTime();
    $leeftijd = $huidigeDatum->diff($geboortedatum)->y;

    // Bepaal het soort lid op basis van de leeftijd
    if ($leeftijd < 8) {
        $soort_lid_id = 1; // Jeugd
    } elseif ($leeftijd >= 8 && $leeftijd <= 12) {
        $soort_lid_id = 2; // Aspirant
    } elseif ($leeftijd >= 13 && $leeftijd <= 17) {
        $soort_lid_id = 3; // Junior
    } elseif ($leeftijd >= 18 && $leeftijd <= 50) {
        $soort_lid_id = 4; // Senior
    } else {
        $soort_lid_id = 5; // Oudere
    }

    // Bepaal het bedrag op basis van het soort lid
    $bedrag = 0;
    switch ($soort_lid_id) {
        case 1:
            $bedrag = 50; // Bedrag voor Jeugd
            break;
        case 2:
            $bedrag = 60; // Bedrag voor Aspirant
            break;
        case 3:
            $bedrag = 70; // Bedrag voor Junior
            break;
        case 4:
            $bedrag = 100; // Bedrag voor Senior
            break;
        case 5:
            $bedrag = 80; // Bedrag voor Oudere
            break;
    }

    // Maak een nieuwe contributie aan en bewaar het bericht
    $message = $contributieController->create($leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id);
    header("Location: view.php?message=" . urlencode($message));
    exit();
}

// Haal alle familieleden en boekjaren op voor de dropdowns
$familieleden = $familielidController->readAll();
$boekjaren = $boekjaarController->getAll();
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
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Formulier om een nieuwe contributie toe te voegen -->
            <form method="post" action="create.php">
                <div>
                    <label for="familielid_id">Familielid</label>
                    <select id="familielid_id" name="familielid_id" required>
                        <?php foreach ($familieleden as $familielid): ?>
                        <option value="<?php echo htmlspecialchars($familielid['id']); ?>">
                            <?php echo htmlspecialchars($familielid['naam']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="boekjaar_id">Boekjaar</label>
                    <select id="boekjaar_id" name="boekjaar_id" required>
                        <?php foreach ($boekjaren as $boekjaar): ?>
                        <option value="<?php echo htmlspecialchars($boekjaar['id']); ?>">
                            <?php echo htmlspecialchars($boekjaar['jaar']); ?>
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