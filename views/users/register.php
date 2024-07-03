<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/UsersController.php';

// Controleer de databaseverbinding
if (!$conn) {
    echo "Geen verbinding met de database";
    exit();
}

// Maak een nieuwe UsersController aan met de database verbinding
$usersController = new UsersController($conn);

$message = '';

// Verwerken van het registratieformulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Probeer de gebruiker te registreren
    $message = $usersController->register($username, $email, $password);
    if ($message === true) {
        // Als de registratie succesvol is, omleiden naar de loginpagina
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Registreren</h1>
    </header>
    <main class="center-content">
        <div class="content">
            <!-- Toon foutmelding indien aanwezig -->
            <?php if ($message && $message !== true): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Registratieformulier -->
            <form method="post" action="register.php">
                <div>
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <button type="submit">Registreren</button>
                </div>
            </form>
            <p>Al een account? <a href="login.php">Inloggen</a></p>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>