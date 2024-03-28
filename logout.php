<?php
    session_start();
    // Check if the user is logged in
    if (isset($_SESSION['who'])) {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();
    }
    header("Location: index.php");
?>
