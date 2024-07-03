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

// Maak een controller aan voor familieleden
$familielidController = new FamilielidController($conn);

// Haal alle familieleden op met hun familienaam en soort lid naam
$familieleden = $familielidController->readAllWithDetails();

$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familieleden Bekijken</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Familieleden Bekijken</h1>
    </header>
    <main>
        <nav>
            <ul>
                <li><a href="../users/welcome.php">Dashboard</a></li>
                <li><a href="create.php">Familielid Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Alle Familieleden</h2>
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <?php if (!empty($familieleden)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Geboortedatum</th>
                        <th>Familie</th>
                        <th>Soort Lid</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($familieleden as $familielid): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($familielid['id']); ?></td>
                        <td><?php echo htmlspecialchars($familielid['naam']); ?></td>
                        <td><?php echo htmlspecialchars($familielid['geboortedatum']); ?></td>
                        <td><?php echo htmlspecialchars($familielid['familie_naam']); ?></td>
                        <td><?php echo htmlspecialchars($familielid['soortlid_naam']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo htmlspecialchars($familielid['id']); ?>"
                                class="action-link">Bewerken</a>
                            <a href="delete.php?id=<?php echo htmlspecialchars($familielid['id']); ?>"
                                class="action-link">Verwijderen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Geen familieleden gevonden.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>