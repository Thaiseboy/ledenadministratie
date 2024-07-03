<?php
// Start de sessie
session_start();
// Vereiste configuratie- en controllerbestanden
require_once '../../config/config.php';
require_once '../../controllers/UsersController.php';

// Maak een nieuwe UsersController aan met de database verbinding
$usersController = new UsersController($conn);

$message = '';

// Verwerken van het inlogformulier bij een POST verzoek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Controleer de inloggegevens
    if ($usersController->login($username, $password)) {
        // Als de inloggegevens correct zijn, omleiden naar de welkomstpagina
        header("Location: ../users/welcome.php");
        exit();
    } else {
        // Als de inloggegevens incorrect zijn, toon een foutmelding
        $message = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Inloggen</h1>
    </header>
    <main class="center-content">
        <div class="content">
            <!-- Toon foutmelding indien aanwezig -->
            <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <!-- Inlogformulier -->
            <form method="post" action="login.php">
                <div>
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <button type="submit">Inloggen</button>
                </div>
            </form>
            <p>Nog geen account? <a href="register.php">Registreren</a></p>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>