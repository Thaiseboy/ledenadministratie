<?php

// Bepaal het soort lid en de korting op basis van de leeftijd
function bepaalContributie($leeftijd) {
    if ($leeftijd < 8) {
        return ['soort_lid_id' => 1, 'korting' => 0.5]; // Jeugd
    } elseif ($leeftijd >= 8 && $leeftijd <= 12) {
        return ['soort_lid_id' => 2, 'korting' => 0.4]; // Aspirant
    } elseif ($leeftijd >= 13 && $leeftijd <= 17) {
        return ['soort_lid_id' => 3, 'korting' => 0.25]; // Junior
    } elseif ($leeftijd >= 18 && $leeftijd <= 50) {
        return ['soort_lid_id' => 4, 'korting' => 0.0]; // Senior
    } else {
        return ['soort_lid_id' => 5, 'korting' => 0.45]; // Oudere
    }
}

// Veilig ontsmetten van HTML-output
function sanitize($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Redirect met een sessiebericht
function redirectWithMessage($url, $message) {
    $_SESSION['message'] = $message;
    header("Location: $url");
    exit();
}

?>