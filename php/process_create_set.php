<?php
session_start();
include '../database_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby tworzyć zestawy.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $set_name = mysqli_real_escape_string($conn, $_POST['set_name']);
    $set_info = mysqli_real_escape_string($conn, $_POST['set_info']);

    // Tworzymy zestaw w tabeli flashcard_sets
    $sql_set = "INSERT INTO flashcard_sets (user_id, set_name, set_info) VALUES ('$user_id', '$set_name', '$set_info')";
    if (mysqli_query($conn, $sql_set)) {
        $set_id = mysqli_insert_id($conn); // Pobieramy ID nowo utworzonego zestawu

        // Dodajemy fiszki do zestawu
        $terms = $_POST['terms'];
        $definitions = $_POST['definitions'];

        for ($i = 0; $i < count($terms); $i++) {
            $term = mysqli_real_escape_string($conn, $terms[$i]);
            $definition = mysqli_real_escape_string($conn, $definitions[$i]);
            $sql_card = "INSERT INTO flashcards (set_id, term, definition) VALUES ('$set_id', '$term', '$definition')";
            mysqli_query($conn, $sql_card);
        }

        echo "Zestaw został utworzony!";
        header("Location: ../views/user_flashcards.html");
        exit();
    } else {
        echo "Błąd przy tworzeniu zestawu: " . mysqli_error($conn);
    }
}
?>
