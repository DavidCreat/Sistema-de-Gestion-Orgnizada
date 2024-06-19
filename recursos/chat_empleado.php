<?php
session_start();
include '../recursos/funcionalidad/php/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];
$result_group = $conn->query("SELECT g.group_name
                              FROM groups g
                              INNER JOIN users u ON g.id = u.id
                              WHERE u.id = $logged_in_user_id");

if ($result_group->num_rows > 0) {
    $group_row = $result_group->fetch_assoc();
    $group_name = $group_row['group_name'];
} else {
    $group_name = "No asignado a un grupo";
}
$result_tasks = $conn->query("SELECT * FROM tasks WHERE assigned_to = $logged_in_user_id");
$tareas = array();
while ($row = $result_tasks->fetch_assoc()) {
    $tareas[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGO</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .messages {
            background-color: #f2f2f2;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .messagesHead {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .messagesHead h2 {
            font-size: 1.5rem;
            color: #333;
        }

        .chat-container {
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .chat-header h2 {
            font-size: 1.2rem;
            color: #333;
        }

        .chat-messages {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px 0;
        }

        .chat-input {
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .chat-input input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
        }

        .chat-input button {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <header>
                <div class="logo">
                    <h2>SGO</h2>
                    <div class="close">
                        <span class="material-symbols-outlined">
                            close
                        </span>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li>
                            <a href="#">
                                <span class="material-symbols-outlined">
                                    chat_bubble
                                </span>
                                <span class="title">Mensaje</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="material-symbols-outlined">
                                    group
                                </span>
                                <span class="title">Mis Compañeros</span>
                            </a>
                        </li>
                        <li>
                            <a href="dashboard_empleado.php">
                                <span class="material-symbols-outlined full">
                                    dashboard
                                </span>
                                <span class="title">Tablero</span>
                            </a>
                        </li>
                        <li>
                            <a href="tareas_empleado.php">
                                <span class="material-symbols-outlined">
                                    task
                                </span>
                                <span class="title">Mis Tareas</span>
                            </a>
                        </li>
                        <li>
                            <a href="generar_informe.php">
                                <span class="material-symbols-outlined">
                                    publish
                                </span>
                                <span class="title">Generar Informe</span>
                            </a>
                        </li>
                        <li>
                            <a href="../index.html">
                                <span class="material-symbols-outlined">
                                    home
                                </span>
                                <span class="title">Inicio</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>
        </div>
        <div class="right">
            <div class="top">
                <div class="searchBx">
                    <h2>Tablero</h2>
                    <div class="inputBx">
                        <span class="material-symbols-outlined searchOpen">
                            search
                        </span>
                        <input type="text" placeholder="Buscar...">
                        <span class="material-symbols-outlined searchClose">
                            close
                        </span>
                    </div>
                </div>
                <div class="user">
                    <span class="material-symbols-outlined">
                        notifications
                    </span>
                    <div class="userImg">
                        <img src="https://avatars.githubusercontent.com/u/80436092?v=4" alt="usuario">
                    </div>
                    <h2>David<br><span>Administrador</span></h2>
                    <div class="arrow">
                        <span class="material-symbols-outlined">
                            expand_more
                        </span>
                    </div>
                    <div class="toggle">
                        <span class="material-symbols-outlined">
                            menu
                        </span>
                        <span class="material-symbols-outlined">
                            close
                        </span>
                    </div>
                </div>
            </div>
            <div class="messages">
                <div class="messagesHead">
                    <h2>Mensajes</h2>
                </div>
                <div class="chat-container">
                    <div class="chat-header">
                        <h2>Chat</h2>
                    </div>
                    <div class="chat-messages" id="chat-messages">
                        <!-- Aquí se agregarán los mensajes -->
                    </div>
                    <div class="chat-input">
                        <input type="text" id="message-input" placeholder="Escribe un mensaje..." />
                        <button onclick="sendMessage()">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../recursos/funcionalidad/js/dashboardfront.js"></script>
</body>

</html>