<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby zobaczyć swoje zestawy.";
    exit();
}

include '../database_connection.php';
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Tworzenie Zestawu</title>
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
                        <li class="uk-active">
                            <a>Zestawy</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav uk-nav-divider">
                                    <li><a href="../php/all_sets.php">Wszystkie zestawy</a></li>
                                    <li><a href="../php/my_sets.php">Moje zestawy</a></li>
                                    <li class="uk-active"><a href="../views/create_set.php">Stwórz zestaw</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a>Fiszki</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav uk-nav-divider">
                                    <li><a href="../views/user_flashcards.php">Moje Fiszki</a></li>
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
                <li><a href="../views/user_flashcards.php">Moje Fiszki</a></li>
                <li class="uk-active"><a href="../views/create_set.php">Stwórz zestaw</a></li>
                <li><a href="../views/flashcards.php">Stwórz Fiszkę</a></li>
                <li><a href="#">Ustawienia</a></li>
            </ul>
        </div>
        <div class="uk-width-3-4@l uk-width-1-1@s uk-text-bold">
            <!-- Zawartość strony -->
            <h2>Tworzenie Zestawu Fiszek</h2>
            <form action="../php/create_set.php" method="POST">
                <label for="set_name">Nazwa zestawu:</label><br>
                <input type="text" id="set_name" name="set_name" required><br><br>

                <label for="set_info">Opis zestawu:</label><br>
                <textarea id="set_info" name="set_info" required></textarea><br><br>

                <div id="flashcards">
                    <div class="flashcard">
                        <label for="term_1">Termin:</label><br>
                        <input type="text" id="term_1" name="flashcards[0][term]" required><br><br>

                        <label for="definition_1">Definicja:</label><br>
                        <textarea id="definition_1" name="flashcards[0][definition]" required></textarea><br><br>
                    </div>
                </div>

                <button type="button" onclick="addFlashcard()">Dodaj fiszkę</button><br><br>
                <input type="submit" value="Dodaj zestaw">
            </form>
        </div>
    </div>
    <script>
        let flashcardCount = 1;

        function addFlashcard() {
            if (flashcardCount < 50) {
                let flashcardDiv = document.createElement("div");
                flashcardDiv.classList.add("flashcard");

                flashcardDiv.innerHTML = `
                    <label for="term_${flashcardCount + 1}">Termin:</label><br>
                    <input type="text" id="term_${flashcardCount + 1}" name="flashcards[${flashcardCount}][term]" required><br><br>
                    <label for="definition_${flashcardCount + 1}">Definicja:</label><br>
                    <textarea id="definition_${flashcardCount + 1}" name="flashcards[${flashcardCount}][definition]" required></textarea><br><br>
                `;
                document.getElementById("flashcards").appendChild(flashcardDiv);
                flashcardCount++;
            } else {
                alert("Maksymalna liczba fiszek to 50.");
            }
        }
    </script>
</body>

</html>