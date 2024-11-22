<?php
session_start(); // Rozpoczynamy sesję

// Sprawdzamy, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby zobaczyć swoje fiszki.";
    exit();
}

include '../database_connection.php'; // Dołączamy połączenie do bazy danych

// Pobieramy user_id z sesji
$user_id = $_SESSION['user_id'];

// Zapytanie SQL, aby pobrać fiszki przypisane do użytkownika
$sql = "SELECT * FROM flashcards WHERE user_id = '$user_id'";

// Wykonujemy zapytanie
$result = mysqli_query($conn, $sql);

// Sprawdzamy, czy są jakieś fiszki
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje Fiszki</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Link do pliku CSS -->
</head>
<body>
    <h2>Twoje Fiszki</h2>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="flashcards-container">
            <?php
            // Jeśli są fiszki, wyświetlamy je
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='flashcard' onclick='flipCard(this)'>";
                echo "<p class='flashcard-term'>" . $row['term'] . "</p>";
                echo "<p class='flashcard-definition'>" . $row['definition'] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    <?php } else { ?>
        <p>Nie masz żadnych fiszek.</p>
    <?php } ?>

    <script>
        // Funkcja, która zmienia widoczność definicji po kliknięciu na fiszkę
        function flipCard(card) {
            var term = card.querySelector('.flashcard-term');
            var definition = card.querySelector('.flashcard-definition');

            if (definition.style.display === "none" || definition.style.display === "") {
                definition.style.display = "block";  // Pokazuje definicję
                term.style.display = "none";         // Ukrywa termin
            } else {
                definition.style.display = "none";   // Ukrywa definicję
                term.style.display = "block";        // Pokazuje termin
            }
        }
    </script>

</body>
</html>

<?php
// Zamykamy połączenie z bazą danych
mysqli_close($conn);
?>
