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
$familielidController = new FamilielidController($conn);
$boekjaarController = new BoekjaarController($conn);

// Controleer of er een ID is meegegeven, anders omleiden naar de weergavepagina
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

// Haal de contributie op basis van het ID
$contributie = $contributieController->getById($_GET['id']);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leeftijd = $_POST['leeftijd'];
    $soort_lid_id = $_POST['soort_lid_id'];
    $bedrag = $_POST['bedrag'];
    $familielid_id = $_POST['familielid_id'];
    $boekjaar_id = $_POST['boekjaar_id'];
    // Update de contributie en bewaar het bericht
    $message = $contributieController->update($_GET['id'], $leeftijd, $soort_lid_id, $bedrag, $familielid_id, $boekjaar_id);
    header("Location: view.php?message=" . urlencode($message));
    exit();
}

// Haal alle familieleden en boekjaren op voor de dropdowns
$familieleden = $familielidController->readAll();
$boekjaren = $boekjaarController->readAll();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributie Bewerken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Contributie Bewerken</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="view.php">Contributies Bekijken</a></li>
                <li><a href="create.php">Contributie Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Contributie Bewerken</h2>
            <!-- Toon bericht na het bijwerken van een contributie -->
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Formulier om een bestaande contributie te bewerken -->
            <form method="post" action="edit.php?id=<?php echo htmlspecialchars($_GET['id']); ?>">
                <div>
                    <label for="leeftijd">Leeftijd</label>
                    <input type="text" id="leeftijd" name="leeftijd"
                        value="<?php echo htmlspecialchars($contributie['leeftijd']); ?>" required>
                </div>
                <div>
                    <label for="soort_lid_id">Soort Lid</label>
                    <input type="text" id="soort_lid_id" name="soort_lid_id"
                        value="<?php echo htmlspecialchars($contributie['soort_lid_id']); ?>" required>
                </div>
                <div>
                    <label for="bedrag">Bedrag</label>
                    <input type="text" id="bedrag" name="bedrag"
                        value="<?php echo htmlspecialchars($contributie['bedrag']); ?>" required>
                </div>
                <div>
                    <label for="familielid_id">Familielid</label>
                    <select id="familielid_id" name="familielid_id" required>
                        <?php foreach ($familieleden as $familielid): ?>
                        <option value="<?php echo htmlspecialchars($familielid['id']); ?>"
                            <?php echo $familielid['id'] == $contributie['familielid_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($familielid['naam']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="boekjaar_id">Boekjaar</label>
                    <select id="boekjaar_id" name="boekjaar_id" required>
                        <?php foreach ($boekjaren as $boekjaar): ?>
                        <option value="<?php echo htmlspecialchars($boekjaar['id']); ?>"
                            <?php echo $boekjaar['id'] == $contributie['boekjaar_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($boekjaar['jaar']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
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