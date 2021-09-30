<?php
session_start();
unset($_SESSION["user_loggedin"]);
header("Location: index.php");
?>