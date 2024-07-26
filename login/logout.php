<?php
// logout.php
include 'auth.php';
logout();
header("Location: showLogin.php");
exit();
?>
