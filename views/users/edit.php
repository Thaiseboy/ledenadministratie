<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();

// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/FamilielidController.php';
require_once '../../controllers/FamiliesController.php';

// Maak controllers aan voor familieleden en families
$familielidController = new FamilielidController($conn);
$familiesController = new FamiliesController($conn);

// Controleer of er een ID is meegegeven, anders omleiden naar de weergavepagina
if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

// Haal het familielid op basis van het ID
$familielid = $familielidController->getById($_GET['id']);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $geboortedatum = $_POST['geboortedatum'];
    $soort_lid_id = $_POST['soort_lid_id'];
    $familie_id = $_POST['familie_id'];
    // Update het familielid en bewaar het bericht
    $message = $familielidController->update($_GET['id'], $naam, $geboortedatum, $soort_lid_id, $familie_id);
    header("Location: view.php?message=" . urlencode($message));
    exit();
}

// Haal alle families op voor de dropdown
$families = $familiesController->readAll();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familielid Bewerken</title>
    <link rel="stylesheet" href="../../style.css">
    <script>
    function calculateSoortLid() {
        var geboortedatum = document.getElementById('geboortedatum').value;
        if (geboortedatum) {
            var today = new Date();
            var birthDate = new Date(geboortedatum);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            var soortLidId;
            if (age < 8) {
                soortLidId = 1; // Jeugd
            } else if (age >= 8 && age <= 12) {
                soortLidId = 2; // Aspirant
            } else if (age >= 13 && age <= 17) {
                soortLidId = 3; // Junior
            } else if (age >= 18 && age <= 50) {
                soortLidId = 4; // Senior
            } else {
                soortLidId = 5; // Oudere
            }

            var soortLidNaam = '';
            switch (soortLidId) {
                case 1:
                    soortLidNaam = 'Jeugd';
                    break;
                case 2:
                    soortLidNaam = 'Aspirant';
                    break;
                case 3:
                    soortLidNaam = 'Junior';
                    break;
                case 4:
                    soortLidNaam = 'Senior';
                    break;
                case 5:
                    soortLidNaam = 'Oudere';
                    break;
            }

            document.getElementById('soort_lid_id').value = soortLidId;
            document.getElementById('soort_lid').value = soortLidNaam;
        }
    }

    // Vult het soort lid in bij het laden van de pagina
    window.onload = function() {
        calculateSoortLid();
    };
    </script>
</head>

<body>
    <header>
        <h1>Familielid Bewerken</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="welcome.php">Dashboard</a></li>
                <li><a href="view.php">Familieleden Bekijken</a></li>
                <li><a href="create.php">Familielid Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Familielid Bewerken</h2>
            <!-- Toon bericht na het bijwerken van een familielid -->
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Formulier om een bestaand familielid te bewerken -->
            <form method="post" action="edit.php?id=<?php echo htmlspecialchars($_GET['id']); ?>">
                <div>
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam"
                        value="<?php echo htmlspecialchars($familielid['naam']); ?>" required>
                </div>
                <div>
                    <label for="geboortedatum">Geboortedatum</label>
                    <input type="date" id="geboortedatum" name="geboortedatum"
                        value="<?php echo htmlspecialchars($familielid['geboortedatum']); ?>"
                        onchange="calculateSoortLid()" required>
                </div>
                <div>
                    <label for="soort_lid">Soort Lid</label>
                    <input type="text" id="soort_lid" name="soort_lid"
                        value="<?php echo htmlspecialchars($familielid['soort_lid']); ?>" readonly>
                    <input type="hidden" id="soort_lid_id" name="soort_lid_id"
                        value="<?php echo htmlspecialchars($familielid['soort_lid_id']); ?>">
                </div>
                <div>
                    <label for="familie_id">Familie</label>
                    <select id="familie_id" name="familie_id" required>
                        <option value="">Selecteer een familie</option>
                        <!-- Loop door elke familie en toon in een dropdown optie -->
                        <?php foreach ($families as $familie): ?>
                        <option value="<?php echo htmlspecialchars($familie['id']); ?>"
                            <?php echo $familie['id'] == $familielid['familie_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($familie['naam']); ?>
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