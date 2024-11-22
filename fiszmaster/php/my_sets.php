<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby zobaczyć swoje zestawy.";
    exit();
}

include '../database_connection.php';
$user_id = $_SESSION['user_id'];

// Pobieramy zestawy użytkownika
$sql = "SELECT * FROM flashcard_sets WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Moje zestawy</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Moje zestawy</h2>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li>
                    <a href="display_flashcards.php?set_id=<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['set_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    <p><?php echo htmlspecialchars($row['set_info'], ENT_QUOTES, 'UTF-8'); ?></p>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Nie masz jeszcze żadnych zestawów.</p>
    <?php } ?>
    <a href="../index.php">Strona główna</a>
</body>
</html>
