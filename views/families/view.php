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
// Haal alle families op
$families = $familiesController->readAll();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Families Bekijken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Families Bekijken</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="create.php">Familie Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Families</h2>
            <!-- Toon bericht na bewerking of verwijdering van een familie -->
            <?php if (isset($_GET['message'])): ?>
            <div class="message"><?php echo htmlspecialchars($_GET['message']); ?></div>
            <?php endif; ?>
            <!-- Tabel met alle families -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Adres</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop door elke familie en toon in een tabelrij -->
                    <?php foreach ($families as $familie): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($familie['id']); ?></td>
                        <td><?php echo htmlspecialchars($familie['naam']); ?></td>
                        <td><?php echo htmlspecialchars($familie['adres']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $familie['id']; ?>" class="action-link">Bewerken</a>
                            <a href="delete.php?id=<?php echo $familie['id']; ?>" class="action-link">Verwijderen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>