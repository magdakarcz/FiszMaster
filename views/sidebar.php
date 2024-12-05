<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div>
        <!-- Hamburger Icon before "Strona główna" -->
        <button id="toggle-nav-button" class="uk-button uk-button-default">
            <span uk-icon="icon: menu; ratio: 1.5"></span> <!-- Hamburger icon here -->
        </button> 

        <!-- Logo Section -->
        <div class="logo-container">
            <img src="../assets/logo.png" alt="FiszMaster">
        </div>
        
        <!-- Navigation Links -->
        <ul>
            <li><a href="../"><i uk-icon="home"></i><span> Strona główna</span></a></li>
            <li><a href="../php/all_sets.php" class="uk-active"><i uk-icon="file"></i><span> Wszystkie zestawy</span></a></li>
            <li><a href="../php/my_sets.php"><i uk-icon="heart"></i><span> Moje zestawy</span></a></li>
            <li><a href="../views/create_set.php"><i uk-icon="plus-circle"></i><span> Stwórz zestaw</span></a></li>
            <li><a href="#"><i uk-icon="settings"></i><span> Ustawienia</span></a></li>
        </ul>
    </div>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <button class="logout-btn">Wyloguj się</button>
    <?php endif; ?>
</div>
