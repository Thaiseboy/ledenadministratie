<?php
// Start de sessie
session_start();
// Controleer of de gebruiker al is ingelogd
if (isset($_SESSION['username'])) {
    // Als de gebruiker is ingelogd, omleiden naar de welkomstpagina
    header("Location: views/users/welcome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Ledenadministratiesysteem</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="views/users/login.php">Inloggen</a></li>
                <li><a href="views/users/register.php">Registreren</a></li>
            </ul>
        </nav>
        <div class="content center-content">
            <div>
                <h2>Welkom</h2>
                <p>Welkom bij het ledenadministratiesysteem. Log in of registreer om verder te gaan.</p>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>