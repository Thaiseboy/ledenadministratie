<?php
// Schakel foutmeldingen in voor debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start de sessie
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['username'])) {
    // Als de gebruiker niet is ingelogd, omleiden naar de loginpagina
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <header>
        <h1>Welkom, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    </header>
    <main>
        <!-- Navigatiemenu -->
        <nav>
            <ul>
                <li><a href="welcome.php">Dashboard</a></li>
                <li><a href="../families/view.php">Families</a></li>
                <li><a href="../users/view.php">Familieleden</a></li>
                <li><a href="../boekjaar/view.php">Boekjaren</a></li>
                <li><a href="../contributie/view.php">Contributies</a></li>
                <li><a href="../../logout.php">Log uit</a></li>
            </ul>
        </nav>
        <div class="content">
            <h2>Dashboard</h2>
            <p>Welkom bij het ledenadministratiesysteem. Gebruik het menu om leden toe te voegen of te bekijken.</p>
            <img src="img/get.jpeg" alt="Get">
            <p>(Get) Master Supakon Karanyawad</p>
            <p>studentnummer: 316735868</p>
            <p>Datum: 03/07/2024</p>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Ledenadministratie</p>
    </footer>
</body>

</html>