<?php
include '../database_connection.php';
session_start(); // Rozpoczynamy sesję

// Pobieramy zapytanie wyszukiwania z formularza
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Tworzymy zapytanie SQL z warunkiem wyszukiwania
$sql = "SELECT * FROM flashcard_sets";
if (!empty($search_query)) {
    $sql .= " WHERE set_name LIKE '%$search_query%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wszystkie zestawy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
   
</head>
<body>
<?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <form method="GET" action="all_sets.php" class="search-bar">
            <input type="text" name="search" placeholder="Szukaj zestawów..." 
                   value="<?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit">Szukaj</button>
        </form>

        <h2>Wszystkie zestawy</h2>
        <hr>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="uk-child-width-1-2@l uk-grid-match" uk-grid>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div>
                        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
                            <a href="display_flashcards.php?set_id=<?php echo $row['id']; ?>" style="text-decoration: none;">
                                <h3><?php echo htmlspecialchars($row['set_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p><?php echo htmlspecialchars($row['set_info'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <b>Język</b>: <?php echo htmlspecialchars($row['set_language'], ENT_QUOTES, 'UTF-8'); ?>, 
                                <b>Poziom</b>: <?php echo htmlspecialchars($row['set_level'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Nie masz jeszcze żadnych zestawów.</p>
        <?php endif; ?>
    </div>

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
