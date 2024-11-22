<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="js/flashcards.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
</head>

<body>
    <!-- Nawigacja -->
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky" id="nav">
        <nav class="uk-navbar-container uk-navbar-transparent">
            <div class="uk-container">
                <div uk-navbar>
                    <div class="uk-navbar-left"><a href="/fiszmaster/index.php" class="uk-link-reset logo">FiszMaster</a></div>
                    <div class="uk-navbar-right">
                        <ul class="uk-navbar-nav">
                            <?php
                            session_start(); // Rozpoczynamy sesję
                            
                            // Sprawdzamy, czy użytkownik jest zalogowany
                            if (isset($_SESSION['user_id'])) {
                                // Użytkownik jest zalogowany, wyświetlamy link do wylogowania
                                echo '<li><a href="views/create_set.html"><button class="uk-button uk-button-primary uk-border-rounded">Stwórz zestaw fiszek </button></a></li>';
                                echo '<li><a href="php/my_sets.php">Moje zestawy</a></li>';
                                echo '<li><a href="php/all_sets.php">Wszystkie zestawy</a></li>';
                                echo '<li><a  href="php/logout.php"><button class="uk-button uk-button-danger uk-border-rounded">Wyloguj się</button></a></li>';
                            } else {
                                // Użytkownik nie jest zalogowany, wyświetlamy link do logowania
                                echo '<li><a href="views/register.html"><button class="uk-button uk-button-primary uk-border-rounded">Zacznij naukę</button></a></li>';
                                echo '<li><a href="views/login.html"><button class="uk-button uk-button-default uk-border-rounded">Zaloguj się</button></a></li>';
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
                            sraka
    <!-- Strona główna -->
    <div uk-height-match id="welcome">
        <div class="uk-grid-collapse uk-child-width-expand@l uk-flex-middle uk-light" uk-grid>
            <div class="uk-margin-large-top uk-text-center">
                <div class="uk-padding">
                    <h1 class="uk-heading-small">Opanuj język z FiszMaster</h1>
                    <p class="uk-text-lead">Opanuj język, którego chcesz się nauczyć, korzystając z interaktywnych
                        fiszek.</p>
                    <p class="uk-text-lead">
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '<a href="views/user_flashcards.php"><button class="uk-button uk-button-primary uk-border-rounded">Moje fiszki</button></a>';
                        } else {
                            echo '<a href="views/register.html"><button class="uk-button uk-button-primary uk-border-rounded">Zacznij naukę</button></a>';
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="uk-text-center">
                <div class="uk-padding">
                    <img src="assets/1.png" />
                </div>
            </div>
        </div>
    </div>
    <div uk-height-match id="whyFiszMaster">
        <div class="uk-grid-collapse uk-child-width-expand@l uk-flex-middle" uk-grid>
            <div class="uk-text-center">
                <div class="uk-padding"><img src="assets/2.png" /></div>
            </div>
            <div class="uk-margin-large-top uk-text-center">
                <div class="uk-padding">
                <h1 class="uk-heading-small">Dlaczego warto uczyć się języka z FiszMaster?</h1>
                    <p class="uk-text-lead">W FiszMaster możesz tworzyć własne fiszki. Dla łatwiejszego przyswajania
                        wiedzy możesz dodać do nich obrazy, kategorie i poziom zaawansowania. Nie chcesz tworzyć
                        własnego zestawu? Skorzystaj z wielu gotowych.</p>
                    <p class="uk-text-lead">FiszMaster wie jak Cię zmotywować do nauki. Zdobywaj osiągnięcia, punkty i
                        obserwuj jak pniesz się w rankingu językowych geniuszy. Nie wiesz czego się dziś uczyć?
                        Skorzystaj z przygotowanych przez nas wyzwań, aby urozmaicić swoją naukę.
                    <p>
                </div>
            </div>
        </div>
    </div>
    <div uk-height-match id="benefits">
        <div class="uk-grid-collapse uk-child-width-expand@l uk-flex-middle uk-light" uk-grid>
            <div class="uk-text-center uk-flex-last@l">
                <div class="uk-padding"><img src="assets/3.png" /></div>
            </div>
            <div class="uk-margin-large-top uk-text-center">
                <div class="uk-padding">
                <h1 class="uk-heading-small">Jak działają fiszki?</h1>
                    <p class="uk-text-lead">Fiszki z powodzeniem wykorzystywane są przez uczniów na całym świecie jako
                        samodzielnie wykonana pomoc naukowa, służąca do efektywnego uczenia się. Zasada działania fiszek
                        jest niezwykle prosta. Metoda ta opiera się na systematycznym porządkowaniu wiedzy, co odróżnia
                        ją znacząco od zwykłego, żmudnego zapamiętywania pojęć z listy, podręcznika czy notatek.</p>
                </div>
            </div>
        </div>
    </div>
    <div uk-height-match id="about">
        <div class="uk-grid-collapse uk-child-width-expand@l uk-flex-middle" uk-grid>
            <div class="uk-margin-large-top uk-text-center">
                <div class="uk-padding">
                    <img src="assets/4.png" />
                </div>
            </div>
            <div class="uk-text-center">
                <div class="uk-padding">
                <h1 class="uk-heading-small">Zmotywujemy Cię!</h1>
                    <p class="uk-text-lead">Nauka z FiszMaster to świetne rozwiązanie w szczególności dla wzrokowców,
                        którzy najlepiej zapamiętują poprzez bodźce wizualne. Ponadto, fiszki
                        pozwalają na szybkie powtarzanie określonej partii materiału i efektywne wykorzystanie czasu,
                        np. w podróży, w pracy, na przerwie w szkole. W FiszMaster swoje fiszki możesz układać według
                        kategorii i poziomu zaawansowania języka. Stwórz własny zestaw lub skorzystaj z wielu gotowych.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>