<?php
    session_start();

    $_SESSION['message'] = "we have a session!";

    if (isset($_POST['cancel'])) {
        $_SESSION[] = "Login ;";
        // Redirect the browser to index.php
        header("Location: index.php");
        return;
    }

    $check = "";
    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; //pw: php123

    if (isset($_POST['email']) && isset($_POST['pass'])) {
        unset($_SESSION['email']);
        if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
            $_SESSION['error'] = "User name and password are required";
            header("Location: login.php");
            return;
        } else if (!strpbrk($_POST['email'], '@')) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        } else {
            $check = hash('md5', $salt . $_POST['pass']);
            if ($check == $stored_hash) {
                // Redirect the browser to view.php
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['success'] = "Login success";
                header("Location: view.php");
                error_log("Login success " . $_SESSION['email']);
                return;
            } else {
                error_log("Login fail " . $_POST['email'] . " $check");
                $_SESSION['error'] = "Incorrect password";
                header("Location: login.php");
                error_log("Login fail " . $_POST['email']);
                return;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In: Siobhan Ernest</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
    if (isset($_SESSION['error'])) {
        echo('<p class="error">' . $_SESSION['error'] . "</p>\n");
        unset($_SESSION['error']);
    }
?>

<h1>Welcome to the Autos Page</h1>
<h2>Please Log In</h2>
<?php
    if (isset($_SESSION['success'])) {
        echo('<p class="success">' . $_SESSION['success'] . "</p>\n");
        unset($_SESSION['success']);
    }
?>
<form method="post">
    <label for="email">User Email:</label>
    <input type="text" name="email" id="email"><br/>
    <label for="id_1723">Password</label>
    <input type="password" name="pass" id="id_1723"><br/>
    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">
</form>

<p>
    For a password hint, view source and find a password hint
    in the HTML comments.
    <!-- Hint: The password is the scripting language we are studying (all lower case) followed by 123. -->
</p>
</body>
</html>

