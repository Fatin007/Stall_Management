<?php
session_start();

// $servername = "sql101.infinityfree.com";
// $username = "if0_38729572";
// $password = "nFInvX6Z2jVD";
// $dbname = "if0_38729572_stall";
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "stall";
$conn = new mysqli($servername, $username, $password, $dbname);
// echo "<h1>Connection Successful</h1>";
?>