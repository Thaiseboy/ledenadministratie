<?php
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

// Maak controller aan voor boekjaren
$boekjaarController = new BoekjaarController($conn);

// Haal alle boekjaren op
$boekjaren = $boekjaarController->readAll();
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
                <li><a href="create.php">Boekjaar Toevoegen</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Boekjaren</h2>
            <!-- Tabel met alle boekjaren -->
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
                            <a href="edit.php?id=<?php echo $boekjaar['id']; ?>">Bewerken</a>
                            <a href="delete.php?id=<?php echo $boekjaar['id']; ?>"
                                onclick="return confirm('Weet je zeker dat je dit boekjaar wilt verwijderen?');">Verwijderen</a>
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