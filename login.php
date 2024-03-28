<?php
session_start();
$_SESSION['message'] == "we have a session!" ;
header("Location: index.php");
?>