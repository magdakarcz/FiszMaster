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