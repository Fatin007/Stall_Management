<?php
include 'db.php';

$_SESSION = array();

session_destroy();

header("Location: login.php?success=1&msg=logout_success");
exit;
?>