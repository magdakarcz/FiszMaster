<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stwórz zestaw</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Custom Styling */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            padding: 20px;
            max-width: 100%;
        }

        form {
            max-width: 800px;
        }

        h1, h2, h3 {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <!-- Page Header -->
    <header>
        <h1>Stwórz nowy zestaw</h1>
        <p>Wypełnij formularz, aby stworzyć nowy zestaw fiszek.</p>
    </header>
    <hr>

    <!-- Form Section -->
    <form action="../php/create_set.php" method="POST" class="uk-form-stacked uk-margin-top">
        <!-- Set Details -->
        <div class="uk-margin">
            <label for="set_name" class="uk-form-label">Nazwa zestawu:</label>
            <div class="uk-form-controls">
                <input class="uk-input" type="text" id="set_name" name="set_name" placeholder="Wprowadź nazwę zestawu" required>
            </div>
        </div>

        <div class="uk-margin">
            <label for="set_info" class="uk-form-label">Opis zestawu:</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea" id="set_info" name="set_info" rows="3" placeholder="Wprowadź opis zestawu" required></textarea>
            </div>
        </div>

        <div class="uk-margin">
            <label for="set_language" class="uk-form-label">Język:</label>
            <div class="uk-form-controls">
                <input class="uk-input" type="text" id="set_language" name="set_language" placeholder="Wprowadź język" required>
            </div>
        </div>

        <div class="uk-margin">
            <label for="set_level" class="uk-form-label">Poziom:</label>
            <div class="uk-form-controls">
                <input class="uk-input" type="text" id="set_level" name="set_level" placeholder="Wprowadź poziom (np. podstawowy)" required>
            </div>
        </div>

        <!-- Flashcards Section -->
<div id="flashcards" class="uk-margin">
    <h3>Dodaj fiszki:</h3>
    <div class="flashcard uk-margin uk-card uk-card-default uk-card-body" style="max-width: 100%;">
        <div class="uk-margin">
            <label for="term_1">Termin:</label>
            <input class="uk-input uk-form-width-large" type="text" id="term_1" name="flashcards[0][term]" placeholder="Wprowadź termin" required>
        </div>

        <div class="uk-margin">
            <label for="definition_1">Definicja:</label>
            <textarea class="uk-textarea uk-form-width-large" id="definition_1" name="flashcards[0][definition]" placeholder="Wprowadź definicję" rows="3" required></textarea>
        </div>
    </div>
</div>

<button type="button" class="uk-button uk-button-secondary uk-border-rounded" onclick="addFlashcard()">Dodaj fiszkę</button>
<input type="submit" class="uk-button uk-button-primary uk-border-rounded" value="Dodaj zestaw">
    </form>
</div>

    <script>
       let flashcardCount = 1;

function addFlashcard() {
    if (flashcardCount < 50) {
        let flashcardDiv = document.createElement("div");
        flashcardDiv.classList.add("flashcard", "uk-margin", "uk-card", "uk-card-default", "uk-card-body");

        flashcardDiv.innerHTML = `
            <div class="uk-margin">
                <label for="term_${flashcardCount + 1}">Termin:</label>
                <input class="uk-input uk-form-width-large" type="text" id="term_${flashcardCount + 1}" name="flashcards[${flashcardCount}][term]" placeholder="Wprowadź termin" required>
            </div>

            <div class="uk-margin">
                <label for="definition_${flashcardCount + 1}">Definicja:</label>
                <textarea class="uk-textarea uk-form-width-large" id="definition_${flashcardCount + 1}" name="flashcards[${flashcardCount}][definition]" placeholder="Wprowadź definicję" rows="3" required></textarea>
            </div>
        `;
        
        document.getElementById("flashcards").appendChild(flashcardDiv);
        flashcardCount++;
    } else {
        alert("Maksymalna liczba fiszek to 50.");
    }
}

const toggleNavButton = document.getElementById('toggle-nav-button');
const sidebar = document.getElementById('sidebar');

toggleNavButton.addEventListener('click', () => {
    sidebar.classList.toggle('narrow');
});

    </script>