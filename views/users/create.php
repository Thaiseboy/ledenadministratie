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

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

// Maak controllers aan voor familieleden en families
$familielidController = new FamilielidController($conn);
$familiesController = new FamiliesController($conn);

$message = '';

// Verwerken van het formulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $geboortedatum = $_POST['geboortedatum'];
    $soort_lid_id = $_POST['soort_lid_id'];
    $familie_id = $_POST['familie_id'];
    // Maak een nieuw familielid aan en bewaar het bericht
    $message = $familielidController->create($naam, $geboortedatum, $soort_lid_id, $familie_id);
}

// Haal alle families op voor de dropdown
$families = $familiesController->readAll();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familielid Toevoegen</title>
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
    </script>
</head>

<body>
    <header>
        <h1>Familielid Toevoegen</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="welcome.php">Dashboard</a></li>
                <li><a href="view.php">Familieleden Bekijken</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Nieuw Familielid Toevoegen</h2>
            <!-- Toon bericht na het aanmaken van een familielid -->
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Formulier om een nieuw familielid toe te voegen -->
            <form method="post" action="create.php">
                <div>
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam" required>
                </div>
                <div>
                    <label for="geboortedatum">Geboortedatum</label>
                    <input type="date" id="geboortedatum" name="geboortedatum" onchange="calculateSoortLid()" required>
                </div>
                <div>
                    <label for="soort_lid">Soort Lid</label>
                    <input type="text" id="soort_lid" name="soort_lid" readonly>
                    <input type="hidden" id="soort_lid_id" name="soort_lid_id">
                </div>
                <div>
                    <label for="familie_id">Familie</label>
                    <select id="familie_id" name="familie_id" required>
                        <option value="">Selecteer een familie</option>
                        <!-- Loop door elke familie en toon in een dropdown optie -->
                        <?php foreach ($families as $familie): ?>
                        <option value="<?php echo htmlspecialchars($familie['id']); ?>">
                            <?php echo htmlspecialchars($familie['naam']); ?>
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