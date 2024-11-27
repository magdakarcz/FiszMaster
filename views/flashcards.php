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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Fiszkę</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
    <style>
        #navLogged {
            background: linear-gradient(20.78deg, #6e00f8 3.3%, #563ce9 27.67%, #116eee 93.23%);
            color: white;
        }
    </style>
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
                                    <li><a href="../views/user_flashcards.php">Moje Fiszki</a></li>
                                    <li class="uk-active"><a href="../views/flashcards.php">Stwórz Fiszkę</a></li>
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
                <li><a href="../views/user_flashcards.php">Moje Fiszki</a></li>
                <li><a href="../views/create_set.php">Stwórz zestaw</a></li>
                <li class="uk-active"><a href="../views/flashcards.php">Stwórz Fiszkę</a></li>
                <li><a href="#">Ustawienia</a></li>
            </ul>
        </div>
        <div class="uk-width-3-4@l uk-width-1-1@s uk-text-bold">
            <!-- Zawartość strony -->
            <h2>Dodaj Fiszkę</h2>
            <form action="../php/add_flashcard.php" method="POST">
                <label for="term">Pojęcie:</label>
                <input type="text" id="term" name="term" required><br><br>

                <label for="definition">Definicja:</label>
                <textarea id="definition" name="definition" required></textarea><br><br>

                <input type="submit" value="Dodaj Fiszkę">
            </form>
        </div>
    </div>
</body>

</html>