<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Siobhan Ernest Week 4</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<main style="max-width: 400px; text-align: center;">
    <h1>Welcome to the Autos Page</h1>
    <?php
        if (isset($_SESSION['message'])) {
            echo('<p class="message">' . $_SESSION['message'] . "</p>\n");
            unset($_SESSION['message']) ;
        }
    ?>
    <p><a href="login.php">Please Log In</a></p>
</main>
</body>
</html>