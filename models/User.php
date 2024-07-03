<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;

    // Constructor, initialiseer de database verbinding
    public function __construct($db) {
        $this->conn = $db;
    }

    // Maak een nieuwe gebruiker aan
    public function create($username, $email, $password) {
        // Hash het wachtwoord voor veilige opslag
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // SQL query om een nieuwe gebruiker in de database toe te voegen
        $query = "INSERT INTO " . $this->table . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);
        
        // Bind de parameters aan de query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        
        // Voer de query uit en controleer of het succesvol was
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Haal een gebruiker op basis van de gebruikersnaam
    public function getUserByUsername($username) {
        // SQL query om een gebruiker op te halen op basis van de gebruikersnaam
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        
        // Bind de gebruikersnaam parameter aan de query
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // Haal het resultaat op als associatieve array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>