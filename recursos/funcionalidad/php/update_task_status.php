<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];
    $update_query = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $new_status, $task_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
