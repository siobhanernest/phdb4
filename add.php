<?php
    session_start();
    // Demand a SESSION parameter
    if (!isset($_SESSION['who']) || strlen($_SESSION['who']) < 1) {
        die('Name parameter missing');
    }
    require_once "pdo.php";

    function urlExists($url_to_check)
    {
        // Initialize an URL to the variable
        $url = $url_to_check;

// Use curl_init() function to initialize a cURL session
        $curl = curl_init($url);

// Use curl_setopt() to set an option for cURL transfer
        curl_setopt($curl, CURLOPT_NOBODY, true);

// Use curl_exec() to perform cURL session
        $result = curl_exec($curl);

        if ($result !== false) {

            // Use curl_getinfo() to get information
            // regarding a specific transfer
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($statusCode == 404) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    if (isset($_POST['cancel']) && $_POST['cancel'] == 'Cancel')  {
        $_SESSION['message']  = "Insertion cancelled";
        header("Location: view.php") ;
        return ;
    }

    if (isset($_POST['make']) && isset($_POST['mileage'])
        && isset($_POST['year'])) {
        if (empty($_POST['make'])) {
            $_SESSION['error'] = "Make is required";
        } else {
            if (!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])) {
                $_SESSION['error'] = "Mileage and year must be numeric";
            } else if (!empty($_POST['url']) && !filter_var(filter_var($_POST['url'], FILTER_SANITIZE_URL), FILTER_VALIDATE_URL)) {
                $_SESSION['error'] = "URL must begin with http:// or https://";
            } else if (!empty($_POST['url']) && !urlExists(filter_var($_POST['url'], FILTER_SANITIZE_URL))) {
                $_SESSION['error'] = "The URL is not valid";
            } else {
                $sql = "INSERT INTO autos (make, mileage, year, url) 
              VALUES (:make, :mileage, :year, :url)";
                $make = $_POST['make'];
                $mileage = (int)$_POST['mileage'];
                $year = (int)$_POST['year'];
                $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':make' => $make, ':mileage' => $mileage, ':year' => $year, ':url' => $url));
                $_SESSION['success'] = "Record inserted";
                header("Location: view.php");

            }
        }
    }
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
        if (isset($_SESSION['who'])) {
            echo "<h1>Tracking Autos for: ";
            echo htmlentities($_SESSION['who']);
            echo "</h1>\n";
        }
        if (isset($_SESSION['error'])) {
            echo('<p class="error">' . $_SESSION['error'] . "</p>\n");
            unset($_SESSION['error']);
        }
    ?>
</header>
<main>
    <h2>Add a vehicle using the form below. </h2>
    <form method="post">
        <label for="make">Make:<span class="required">*</span></label>
        <input type="text" name="make" id="make"><br>
        <label for="year">Year:<span class="required">*</span></label>
        <input type="text" name="year" id="year"><br>
        <label for="mileage">Mileage:<span class="required">*</span></label>
        <input type="text" name="mileage" id="mileage"><br>
        <label for="url">URL: (optional)</label>
        <input type="text" name="url" id="url"><br>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <div class="spacer"></div>

</main>
<footer>

</footer>
</body>
</html>

