<?php
session_start();
include '../database_connection.php';

// Sprawdzanie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby dodać zestaw.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $set_name = $_POST['set_name'];
    $set_info = $_POST['set_info'];
    $user_id = $_SESSION['user_id']; // Pobieramy user_id z sesji

    // Sanityzacja danych wejściowych
    $set_name = mysqli_real_escape_string($conn, $set_name);
    $set_info = mysqli_real_escape_string($conn, $set_info);

    // Dodanie zestawu fiszek do bazy danych
    $sql_set = "INSERT INTO flashcard_sets (set_name, set_info, user_id) VALUES ('$set_name', '$set_info', '$user_id')";
    if (mysqli_query($conn, $sql_set)) {
        // Pobranie ID dodanego zestawu
        $set_id = mysqli_insert_id($conn);

        // Dodanie fiszek do zestawu
        if (!empty($_POST['flashcards'])) {
            $flashcards = $_POST['flashcards']; // Zakładamy, że fiszki są przekazywane jako tablica

            foreach ($flashcards as $flashcard) {
                $term = mysqli_real_escape_string($conn, $flashcard['term']);
                $definition = mysqli_real_escape_string($conn, $flashcard['definition']);

                // Wstawianie fiszki do tabeli flashcards z odniesieniem do zestawu
                $sql_flashcard = "INSERT INTO flashcards (term, definition, user_id, set_id) 
                                VALUES ('$term', '$definition', '$user_id', '$set_id')";
                if (!mysqli_query($conn, $sql_flashcard)) {
                    echo "Błąd dodawania fiszki: " . mysqli_error($conn);
                    exit();
                }
            }
        }

        echo "Zestaw i fiszki zostały dodane!";
        header("Location: ../php/my_sets.php"); // Przekierowanie na stronę "Moje zestawy"
        exit();
    } else {
        echo "Błąd dodawania zestawu: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
