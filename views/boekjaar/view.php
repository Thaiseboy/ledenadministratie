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

// Haal alle boekjaren op
$boekjaren = $boekjaarController->getAll();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boekjaren Bekijken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Boekjaren Bekijken</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="../boekjaar/create.php">Boekjaar Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Alle Boekjaren</h2>
            <?php if (!empty($boekjaren)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jaar</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boekjaren as $boekjaar): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($boekjaar['id']); ?></td>
                        <td><?php echo htmlspecialchars($boekjaar['jaar']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo htmlspecialchars($boekjaar['id']); ?>"
                                class="action-link">Bewerken</a>
                            <a href="delete.php?id=<?php echo htmlspecialchars($boekjaar['id']); ?>"
                                class="action-link">Verwijderen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Geen boekjaren gevonden.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>