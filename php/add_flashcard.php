<?php
session_start();
include '../database_connection.php';

// Sprawdzanie, czy użytkownik jest zalogowany na podstawie `user_id`
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby dodawać fiszki.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $term = $_POST['term'];
    $definition = $_POST['definition'];
    $user_id = $_SESSION['user_id']; // Pobieranie `user_id` z sesji

    // Sanityzacja danych wejściowych
    $term = mysqli_real_escape_string($conn, $term);
    $definition = mysqli_real_escape_string($conn, $definition);

    // Wstawianie fiszki z użyciem `user_id`
    $sql = "INSERT INTO flashcards (term, definition, user_id) VALUES ('$term', '$definition', '$user_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Fiszka została dodana!";
        // Przekierowanie na stronę główną po dodaniu fiszki
        header("Location: ../views/user_flashcards.php");
        exit();
    } else {
        echo "Błąd: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
