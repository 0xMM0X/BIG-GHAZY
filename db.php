<?php
$servername = "127.0.0.1";
$username = "Ghazy";
$password = "0xL4ugh_F0R_EV3R!!";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>


