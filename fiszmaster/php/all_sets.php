<?php
include '../database_connection.php';

$sql = "SELECT * FROM flashcard_sets";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Moje zestawy</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Moje zestawy</h2>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li>
                    <h3><?php echo $row['set_name']; ?></h3>
                    <p><?php echo $row['set_info']; ?></p>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>Nie masz jeszcze żadnych zestawów.</p>
    <?php } ?>
    <?php
    echo '<li><a href="../index.php">Strona główna</a></li>';
    ?>
</body>
</html>
