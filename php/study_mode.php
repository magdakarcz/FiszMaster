<?php
include '../database_connection.php';
session_start();

if (!isset($_GET['set_id'])) {
    echo "Nie podano zestawu.";
    exit;
}

$set_id = intval($_GET['set_id']);

// Pobranie zestawu i fiszek z bazy danych
$set_query = "SELECT * FROM flashcard_sets WHERE id = $set_id";
$set_result = mysqli_query($conn, $set_query);
$set = mysqli_fetch_assoc($set_result);

if (!$set) {
    echo "Nie znaleziono zestawu.";
    exit;
}

$flashcards_query = "SELECT * FROM flashcards WHERE set_id = $set_id";
$flashcards_result = mysqli_query($conn, $flashcards_query);
$flashcards = mysqli_fetch_all($flashcards_result, MYSQLI_ASSOC);

if (!$flashcards) {
    echo "Zestaw nie zawiera fiszek.";
    exit;
}

// Inicjalizacja stanu nauki w sesji
if (!isset($_SESSION['study_mode'][$set_id])) {
    $_SESSION['study_mode'][$set_id] = [
        'remaining' => $flashcards,
        'incorrect' => [],
        'score' => 0,
        'current_flashcard' => null,
    ];
}

// Skrócenie dostępu do danych sesji
$study_data = &$_SESSION['study_mode'][$set_id];

// Jeśli brak fiszek do nauki
if (empty($study_data['remaining']) && empty($study_data['incorrect'])) {
    echo "<link rel='stylesheet' href='../css/uikit.min.css' />";
    echo "<link rel='stylesheet' href='../css/style.css'>";
    echo "<div class='uk-position-center' style='margin-top:-2rem'>";
    echo "<div class='uk-container'>";
    echo "<h2>Gratulacje! Ukończyłeś naukę!</h2>";
    echo "<p>Twój wynik: " . $study_data['score'] . "/" . count($flashcards) . "</p>";
    echo "<a href='display_flashcards.php?set_id=$set_id' class='uk-button uk-button-default'>Powrót do zestawu</a>";
    echo "</div>";
    echo "</div>";
    unset($_SESSION['study_mode'][$set_id]);
    exit;
}

// Ustawienie aktualnej fiszki
if (!$study_data['current_flashcard']) {
    if (!empty($study_data['incorrect'])) {
        $study_data['current_flashcard'] = array_shift($study_data['incorrect']);
    } else {
        shuffle($study_data['remaining']);
        $study_data['current_flashcard'] = array_pop($study_data['remaining']);
    }
}

$current_flashcard = $study_data['current_flashcard'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_answer = trim($_POST['definition']);

    if (strcasecmp($user_answer, $current_flashcard['definition']) === 0) {
        $study_data['score']++;
        $feedback = "<span style='color: green'>Dobrze!</span>";
    } else {
        $study_data['incorrect'][] = $current_flashcard;
        $feedback = "<span style='color: red'>Zła odpowiedź. Poprawna odpowiedź to: " . htmlspecialchars($current_flashcard['definition'], ENT_QUOTES, 'UTF-8') . ".</span>";
    }

    // Aktualizacja stanu sesji
    $study_data['current_flashcard'] = null;

    // Wylosowanie nowej fiszki, jeśli jest dostępna
    if (!empty($study_data['incorrect'])) {
        $study_data['current_flashcard'] = array_shift($study_data['incorrect']);
    } elseif (!empty($study_data['remaining'])) {
        shuffle($study_data['remaining']);
        $study_data['current_flashcard'] = array_pop($study_data['remaining']);
    }

    $current_flashcard = $study_data['current_flashcard'];
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Test: <?php echo htmlspecialchars($set['set_name'], ENT_QUOTES, 'UTF-8'); ?></title>
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
    <div class="uk-position-center">
        <div class="uk-container">
            <h2>Tryb nauki: <?php echo htmlspecialchars($set['set_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><?php echo htmlspecialchars($set['set_info'], ENT_QUOTES, 'UTF-8'); ?></p>

            <?php if (isset($feedback)): ?>
                <p><?php echo $feedback; ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="flashcard" id="flashcard">
                    <?php echo htmlspecialchars($current_flashcard['term'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="uk-margin" uk-margin>
                    <div uk-form-custom="target: true">
                        <input type="text" name="definition" class="uk-input" placeholder="Twoja odpowiedź" required>
                    </div>
                    <button type="submit" class="uk-button uk-button-primary">Sprawdź</button>
                </div>
            </form>

            <!--<div class="uk-margin-top">
                <p>Pozostałe fiszki: <?php echo count($study_data['remaining']); ?></p>
                <p>Niepoprawne fiszki: <?php echo count($study_data['incorrect']); ?></p>
                <p>Wynik: <?php echo $study_data['score']; ?></p>
            </div>-->
        </div>
    </div>
    <div class="uk-position-top-right">
        <div class="uk-margin-top">
            <a href="display_flashcards.php?set_id=<?php echo $set_id; ?>" class="uk-button uk-button-default">
                Powrót do zestawu
            </a>
        </div>
    </div>
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