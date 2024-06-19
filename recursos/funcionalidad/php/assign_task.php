<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_task'])) {
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    $sql = "INSERT INTO tasks (task_name, description, assigned_to) VALUES ('$task_name', '$description', '$assigned_to')";
    if ($conn->query($sql) === TRUE) {
        echo "Tarea asignada exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
