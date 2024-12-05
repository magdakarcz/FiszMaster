<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Musisz być zalogowany, aby zobaczyć swoje zestawy.";
    exit();
}

include '../database_connection.php';
$user_id = $_SESSION['user_id'];

// Pobieramy zestawy użytkownika
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql = "SELECT * FROM flashcard_sets WHERE user_id = '$user_id'";
if (!empty($search_query)) {
    $sql .= " AND set_name LIKE '%$search_query%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje zestawy</title>
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
        <form method="GET" action="my_sets.php" class="search-bar">
            <input type="text" name="search" placeholder="Szukaj w swoich zestawach..." 
                   value="<?php echo htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8'); ?>">
            <button type="submit">Szukaj</button>
        </form>

        <h2>Moje zestawy</h2>
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
        // Sidebar toggle logic
        const toggleNavButton = document.getElementById('toggle-nav-button');
        const sidebar = document.getElementById('sidebar');

        toggleNavButton.addEventListener('click', () => {
            sidebar.classList.toggle('narrow');
        });
    </script>
</body>
</html>
