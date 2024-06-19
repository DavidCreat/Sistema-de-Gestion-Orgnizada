<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_group'])) {
    $group_name = $_POST['group_name'];

    $sql = "INSERT INTO groups (group_name) VALUES ('$group_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo grupo creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
