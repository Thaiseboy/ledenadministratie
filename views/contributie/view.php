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

// Maak een controller aan voor contributies
$contributieController = new ContributieController($conn);

// Haal alle contributies op met de namen van soort leden en familielid
$contributies = $contributieController->readAllWithDetails();

$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributies Bekijken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Contributies Bekijken</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="create.php">Contributie Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Alle Contributies</h2>
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <?php if (!empty($contributies)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Familielid</th>
                        <th>Leeftijd</th>
                        <th>Soort Lid</th>
                        <th>Bedrag</th>
                        <th>Boekjaar</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contributies as $contributie): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contributie['id']); ?></td>
                        <td><?php echo htmlspecialchars($contributie['familielid_naam']); ?></td>
                        <td><?php echo htmlspecialchars($contributie['leeftijd']); ?></td>
                        <td><?php echo htmlspecialchars($contributie['soortlid_naam']); ?></td>
                        <td><?php echo htmlspecialchars($contributie['bedrag']); ?></td>
                        <td><?php echo htmlspecialchars($contributie['boekjaar_jaar']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo htmlspecialchars($contributie['id']); ?>"
                                class="action-link">Bewerken</a>
                            <a href="delete.php?id=<?php echo htmlspecialchars($contributie['id']); ?>"
                                class="action-link">Verwijderen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Geen contributies gevonden.</p>
            <?php endif; ?>
            <p>Op basis van de leeftijd in jaren en het soort lid is een afwijkende contributie van toepassing.</p><br>
            <p><strong>Jeugd:</strong> Jonger dan 8 jaar 50% korting</p>
            <p><strong>sprirant:</strong>A van 8 tot 12 jaar 40%</p>
            <p><strong>Junior:</strong> Van 13 tot 17 jaar 25% korting</p>
            <p><strong>Senior:</strong> Van 18 tot 50 jaar 0% korting</p>
            <p><strong>Oudere:</strong> Vanaf 51 jaar 45% korting </p><br>
            <p>Basisbedrag contributie is <strong>100,-</strong> per jaar</p>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>