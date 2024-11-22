<?php
session_start();
include '../database_connection.php'; // Dołączamy plik z połączeniem

// Sprawdzamy, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];  // Pobieramy dane z formularza
    $password = $_POST['password'];

    // Zabezpieczenie przed SQL Injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Zapytanie do bazy danych
    $sql = "SELECT id FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Użytkownik istnieje, logowanie udane
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id']; // Ustawienie `user_id` w sesji
        header("Location: ../index.php"); // Przekierowanie na stronę index.html
        exit(); // Ważne, aby zakończyć działanie skryptu
    } else {
        echo "Błędna nazwa użytkownika lub hasło.";
    }
}
?>
