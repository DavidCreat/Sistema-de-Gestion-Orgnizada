<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_to_group'])) {
    $user_id = $_POST['user_id'];
    $group_id = $_POST['group_id'];

    $sql = "INSERT INTO group_assignments (group_id, user_id) VALUES ('$group_id', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario asignado al grupo exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
