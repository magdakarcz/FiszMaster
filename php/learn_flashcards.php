<?php
include '../database_connection.php';
session_start(); // Rozpoczynamy sesję

// Pobierz id zestawu
$set_id = isset($_GET['set_id']) ? intval($_GET['set_id']) : 0;

// Sprawdź, czy zestaw istnieje
$sql_set = "SELECT * FROM flashcard_sets WHERE id = $set_id";
$result_set = mysqli_query($conn, $sql_set);
if (mysqli_num_rows($result_set) == 0) {
    echo "Zestaw nie istnieje.";
    exit();
}
$set = mysqli_fetch_assoc($result_set);

// Pobierz wszystkie fiszki z zestawu
$sql_flashcards = "SELECT * FROM flashcards WHERE set_id = $set_id";
$result_flashcards = mysqli_query($conn, $sql_flashcards);

// Sprawdź, czy zestaw zawiera fiszki
$flashcards = [];
if (mysqli_num_rows($result_flashcards) > 0) {
    while ($row = mysqli_fetch_assoc($result_flashcards)) {
        $flashcards[] = $row;
    }
} else {
    echo "Zestaw nie zawiera fiszek.";
    exit();
}

// Przechowuj indeks bieżącej fiszki w sesji
if (!isset($_SESSION['current_flashcard'])) {
    $_SESSION['current_flashcard'] = 0; // Start od pierwszej fiszki
}

$current_index = $_SESSION['current_flashcard'];
$total_flashcards = count($flashcards);

// Obsługa nawigacji
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'next') {
        $current_index = ($current_index + 1) % $total_flashcards; // Następna fiszka
    } elseif ($_POST['action'] == 'prev') {
        $current_index = ($current_index - 1 + $total_flashcards) % $total_flashcards; // Poprzednia fiszka
    }
    $_SESSION['current_flashcard'] = $current_index; // Zaktualizuj sesję
}

// Pobierz bieżącą fiszkę
$current_flashcard = $flashcards[$current_index];
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Ucz się: <?php echo htmlspecialchars($set['set_name'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/uikit.min.css" />
    <style>
        .flashcard {
            width: 300px;
            height: 200px;
            margin: 20px auto;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            font-size: 1.5rem;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .flashcard:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="uk-position-center" style="margin-top:-2rem">
        <div class="uk-container">
            <h2>Zestaw: <?php echo htmlspecialchars($set['set_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><?php echo htmlspecialchars($set['set_info'], ENT_QUOTES, 'UTF-8'); ?></p>

            <div class="flashcard" id="flashcard" onclick="flipFlashcard()">
                <?php echo htmlspecialchars($current_flashcard['term'], ENT_QUOTES, 'UTF-8'); ?>
            </div>

            <form method="POST" class="uk-flex uk-flex-between">
                <button name="action" value="prev" class="uk-button uk-button-secondary">Poprzedni</button>
                <button name="action" value="next" class="uk-button uk-button-primary">Następny</button>
            </form>
        </div>
    </div>

    <!-- Dodaj przycisk powrotu -->
    <div class="uk-position-top-right">
        <div class="uk-margin-top">
            <a href="display_flashcards.php?set_id=<?php echo $set_id; ?>" class="uk-button uk-button-default">
                Powrót do zestawu
            </a>
        </div>
    </div>
    </div>

    <script>
        let isFlipped = false; // Czy fiszka jest obrócona
        const flashcard = document.getElementById('flashcard');
        const term = <?php echo json_encode(htmlspecialchars($current_flashcard['term'], ENT_QUOTES, 'UTF-8')); ?>;
        const definition = <?php echo json_encode(htmlspecialchars($current_flashcard['definition'], ENT_QUOTES, 'UTF-8')); ?>;

        function flipFlashcard() {
            if (isFlipped) {
                flashcard.textContent = term;
            } else {
                flashcard.textContent = definition;
            }
            isFlipped = !isFlipped; // Zmieniamy stan
        }
    </script>
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