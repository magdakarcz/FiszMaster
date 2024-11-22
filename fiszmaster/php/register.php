<?php
session_start(); // Rozpoczynamy sesję

// Dołączamy plik z połączeniem do bazy danych
include '../database_connection.php';

// Sprawdzamy, czy formularz został wysłany metodą POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieramy dane z formularza
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Sprawdzamy, czy hasła się zgadzają
    if ($password !== $confirm_password) {
        echo "Hasła nie pasują do siebie.";
        exit();
    }

    // Hasło musi mieć co najmniej 6 znaków
    if (strlen($password) < 6) {
        echo "Hasło musi mieć co najmniej 6 znaków.";
        exit();
    }

    // Zabezpieczenie przed SQL Injection
    $username = mysqli_real_escape_string($conn, $username);  // Załóżmy, że połączenie jest w $conn

    // Zapytanie sprawdzające, czy użytkownik już istnieje w bazie
    $sql_check = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result) > 0) {
        echo "Użytkownik o tej nazwie już istnieje.";
    } else {
        // Haszowanie hasła przed zapisaniem do bazy
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Jeśli użytkownik nie istnieje, dodajemy go do bazy (przechowujemy hasło w postaci haszowanej)
        $sql_insert = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
        
        if (mysqli_query($conn, $sql_insert)) {
            // Po dodaniu użytkownika do bazy, pobieramy jego id
            $user_id = mysqli_insert_id($conn);  // Pobieramy ID ostatnio dodanego użytkownika

            // Ustawiamy sesję na id
            $_SESSION['user_id'] = $user_id;

            echo "Rejestracja zakończona sukcesem. Możesz się zalogować!";
            // Możesz przekierować użytkownika na stronę logowania lub główną stronę
            header("Location: ../views/login.html");
            exit(); // Ważne, aby zakończyć działanie skryptu
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    }

    // Zamykamy połączenie z bazą danych
    mysqli_close($conn);
}
?>
