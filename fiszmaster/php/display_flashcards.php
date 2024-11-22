<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby zobaczyć swoje fiszki.";
    exit();
}

include '../database_connection.php';
$user_id = $_SESSION['user_id'];

// Sprawdzamy, czy został podany `set_id`
if (!isset($_GET['set_id'])) {
    echo "Nie wybrano zestawu.";
    exit();
}

$set_id = intval($_GET['set_id']);

// Pobieramy fiszki dla danego zestawu użytkownika
$sql = "SELECT * FROM flashcards WHERE user_id = '$user_id' AND set_id = '$set_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Fiszki</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Fiszki</h2>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="flashcards">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="flashcard">
                    <p><strong>Termin:</strong> <?php echo htmlspecialchars($row['term'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Definicja:</strong> <?php echo htmlspecialchars($row['definition'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Nie znaleziono fiszek w tym zestawie.</p>
    <?php } ?>
    <a href="my_sets.php">Powrót do zestawów</a>
</body>
</html>
