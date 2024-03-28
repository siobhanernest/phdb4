<?php
session_start();

// Demand a SESSION parameter
    if (!isset($_SESSION['email']) || strlen($_SESSION['email']) < 1) {
        die('Name parameter missing');
    }
    require_once "pdo.php";


    $rows = array("Nothing to see here");
    $stmt = $pdo->query("SELECT make, mileage, year, url FROM autos ORDER BY make ASC, year DESC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="en">
<head>
    <title>Siobhan Ernest Autos Page</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <?php
        if (isset($_SESSION['email'])) {
            echo "<h1>Tracking Autos for: ";
            echo htmlentities($_SESSION['email']);
            echo "</h1>\n";
        }
        if (isset($_SESSION['success'])) {
            echo('<p class="success">' . $_SESSION['success'] . "</p>\n");
            unset($_SESSION['success']);
        }
    ?>
</header>
<main>
    <?php
        foreach ($rows as $row) {
            echo("<li>");
            $output = "";
            $output .= htmlentities($row['year'] ). " ";
            if (strlen($row['url']) > 1) {
                $output .= "<a href=\"" . htmlentities($row['url'] ). "\" target=\"_blank\">";
            }
            $output .= htmlentities($row['make']);
            if (strlen($row['url']) > 1) {
                $output .= "</a>";
            }
            $output .= " / " . htmlentities($row['mileage'] ) . " ";
            echo($output);
            echo("</li>");
        }
    ?>
    <div class="spacer"></div>
    <div class="buttons"><a href="add.php">Add New</a><a href="logout.php">Logout</a> </div>
</main>
<footer>

</footer>
</body>
</html>
