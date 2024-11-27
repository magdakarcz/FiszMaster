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
    <title>Twoje Fiszki</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
</head>

<body>
    <!-- Nawigacja -->
    <nav class="uk-navbar-container" id="navLogged">
        <div class="uk-container">
            <div uk-navbar>
                <div class="uk-navbar-left"><a href="/fiszmaster/index.php"
                        class="uk-link-reset logo uk-text-bold">FiszMaster</a></div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        <?php
                        // Sprawdzamy, czy użytkownik jest zalogowany
                        if (isset($_SESSION['user_id'])) {
                            // Użytkownik jest zalogowany, wyświetlamy link do wylogowania
                            echo '<li><a  href="/php/logout.php"><button class="uk-button uk-button-primary uk-text-bold uk-border-rounded" style="border: 1px solid white;">Wyloguj się</button></a></li>';
                        } else {
                            // Użytkownik nie jest zalogowany, wyświetlamy link do logowania
                            echo '<li><a href="/views/register.html"><button class="uk-button uk-button-primary uk-border-rounded">Zacznij naukę</button></a></li>';
                            echo '<li><a href="/views/login.html"><button class="uk-button uk-button-default uk-border-rounded">Zaloguj się</button></a></li>';
                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Boczna nawigacja - TELEFON -->
    <nav class="uk-navbar-container uk-navbar-transparent uk-hidden@l uk-text-bold" uk-navbar="mode: click"
        style="border-bottom: 1px solid #e5e5e5;">
        <div class="uk-container">
            <div uk-navbar="align: center">
                <div class="uk-navbar-center">
                    <ul class="uk-navbar-nav">
                        <li>
                            <a>Zestawy</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav uk-nav-divider">
                                    <li><a href="../php/all_sets.php">Wszystkie zestawy</a></li>
                                    <li><a href="../php/my_sets.php">Moje zestawy</a></li>
                                    <li><a href="../views/create_set.php">Stwórz zestaw</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="uk-active">
                            <a>Fiszki</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav uk-nav-divider">
                                    <li class="uk-active"><a href="../views/user_flashcards.php">Moje Fiszki</a></li>
                                    <li><a href="../views/flashcards.php">Stwórz Fiszkę</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#">Ustawienia</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="uk-grid-collapse uk-padding-large uk-grid-divider" uk-grid>
        <!-- Boczna nawigacja - KOMPUTER -->
        <div class="uk-width-1-5@l uk-visible@l uk-text-bold">
            <h2>FiszMaster</h2>
            <hr class="uk-divider-small">
            <ul class="uk-nav uk-nav-default uk-list uk-list-divider">
                <li><a href="../">Strona główna</a></li>
                <li><a href="../php/all_sets.php">Wszystkie zestawy</a></li>
                <li><a href="../php/my_sets.php">Moje zestawy</a></li>
                <li class="uk-active"><a href="../views/user_flashcards.php">Moje Fiszki</a></li>
                <li><a href="../views/create_set.php">Stwórz zestaw</a></li>
                <li><a href="../views/flashcards.php">Stwórz Fiszkę</a></li>
                <li><a href="#">Ustawienia</a></li>
            </ul>
        </div>
        <div class="uk-width-1-2@l uk-width-1-1@s uk-text-bold">
            <!-- Zawartość strony -->
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
        </div>
    </div>
</body>

</html>

<?php
// Zamykamy połączenie z bazą danych
mysqli_close($conn);
?>