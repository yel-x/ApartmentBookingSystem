<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "rpabs";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Retrieve all existing records from the table
$query = "SELECT * FROM userInfo";
$result = mysqli_query($conn, $query);

// Loop through each record
while ($row = mysqli_fetch_assoc($result)) {
    // Remove this loop and update code
}