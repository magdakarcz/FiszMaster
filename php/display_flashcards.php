<?php
include '../database_connection.php';
session_start(); // Rozpoczynamy sesję

// Pobieramy ID zestawu z parametrów URL
$set_id = isset($_GET['set_id']) ? (int) $_GET['set_id'] : 0;

if ($set_id <= 0) {
    echo "Nieprawidłowy identyfikator zestawu.";
    exit();
}

// Pobieramy szczegóły zestawu z bazy danych
$sql_set = "SELECT * FROM flashcard_sets WHERE id = $set_id";
$result_set = mysqli_query($conn, $sql_set);

if ($result_set && mysqli_num_rows($result_set) > 0) {
    $set = mysqli_fetch_assoc($result_set);
} else {
    echo "Zestaw nie został znaleziony.";
    exit();
}

// Pobieramy fiszki należące do tego zestawu
$sql_flashcards = "SELECT * FROM flashcards WHERE set_id = $set_id";
$result_flashcards = mysqli_query($conn, $sql_flashcards);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($set['set_name'], ENT_QUOTES, 'UTF-8'); ?></title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="../css/uikit.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content uk-container">
        <header>
            <h1><?php echo htmlspecialchars($set['set_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p><?php echo htmlspecialchars($set['set_info'], ENT_QUOTES, 'UTF-8'); ?></p>
        </header>

        <h2>Fiszki w zestawie</h2>

        <?php if ($result_flashcards && mysqli_num_rows($result_flashcards) > 0) { ?>
            <ul class="uk-list uk-list-divider">
                <?php while ($flashcard = mysqli_fetch_assoc($result_flashcards)) { ?>
                    <li>
                        <div class="flashcard-item">
                            <!-- Pytanie and Term -->
                            <div class="term">
                                <strong>Pytanie:</strong>
                                <?php echo htmlspecialchars($flashcard['term'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <!-- Spacer between question and answer -->
                            <span class="space"> &nbsp; </span>
                            <!-- Odpowiedź and Definition -->
                            <div class="definition">
                                <strong>Odpowiedź:</strong>
                                <?php echo htmlspecialchars($flashcard['definition'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="uk-margin-top">
                <a href="learn_flashcards.php?set_id=<?php echo $set_id; ?>" class="uk-button uk-button-primary">Ucz się z
                    fiszek</a>
                <a href="study_mode.php?set_id=<?php echo $set_id; ?>" class="uk-button uk-button-primary">Test</a>
            <?php } else { ?>
                <p>Ten zestaw nie zawiera jeszcze żadnych fiszek.</p>
                <div class="uk-margin-top">
                    <a style="background-color: grey; opacity: 0.5" class="uk-button uk-button-primary uk-link-muted">Ucz
                        się z fiszek</a>
                    <a style="background-color: grey; opacity: 0.5" class="uk-button uk-button-primary uk-link-muted">Test</a>
                <?php } ?>
                <a href="all_sets.php" class="uk-button uk-button-default uk-border-rounded">Powrót do listy</a>
            </div>
        </div>

        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
        <script>
            // Get the sidebar and toggle button elements
            const toggleNavButton = document.getElementById('toggle-nav-button');
            const sidebar = document.getElementById('sidebar');

            // Add click event listener to the toggle button
            toggleNavButton.addEventListener('click', () => {
                // Toggle the narrow class to shrink/expand the sidebar
                sidebar.classList.toggle('narrow');
            });

        </script>
</body>

</html>