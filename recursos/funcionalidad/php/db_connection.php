<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management_sgo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
