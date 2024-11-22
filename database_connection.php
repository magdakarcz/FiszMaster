<?php
$servername = "localhost";
$username = "root";  // lub inna nazwa użytkownika bazy danych
$password = "";      // lub inne hasło
$dbname = "learning_platform";    // nazwa twojej bazy danych

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}
?>
