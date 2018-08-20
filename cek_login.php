<?php

ob_start();
session_start();
ob_end_clean();
$username = $_POST["username"];
$password = $_POST["password"];
if ($username == "test" AND $password == "inputer") {
    $_SESSION["username"] = $username;
    header("location:verifikasi.php");
} else {
    header("location:loginverifikasi.php?login_error");
}
?>