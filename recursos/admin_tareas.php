<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGO - Tareas</title>
    <link rel="stylesheet" href="./css/dashboard_admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdf4fd;
            color: #111111;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            background-color: #f5c7f7;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #ed9af1;
            color: #111111;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #c8bef3;
        }

        tr:hover {
            background-color: #f5c7f7;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-btn,
        .delete-btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        input[type="text"],
        select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <?php
    include '../recursos/funcionalidad/php/db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['edit_task'])) {
            $task_id = $_POST['task_id'];
            $task_name = $_POST['task_name'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $assigned_to = $_POST['assigned_to'];

            $update_query = "UPDATE tasks SET task_name = '$task_name', description = '$description', status = '$status', assigned_to = '$assigned_to' WHERE id = '$task_id'";
            $conn->query($update_query);
        }

        if (isset($_POST['delete_task'])) {
            $task_id = $_POST['task_id'];
            $delete_query = "DELETE FROM tasks WHERE id = '$task_id'";
            $conn->query($delete_query);
        }
    }

    $result_tasks = $conn->query("SELECT tasks.id, task_name, description, status, assigned_to, users.username FROM tasks LEFT JOIN users ON tasks.assigned_to = users.id");
    $result_users = $conn->query("SELECT id, username FROM users");
    $users = [];
    while ($user = $result_users->fetch_assoc()) {
        $users[$user['id']] = $user['username'];
    }
    ?>

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
                            <a href="admin_tareas.php">
                                <span class="material-symbols-outlined">
                                    task
                                </span>
                                <span class="title">Tareas creadas</span>
                            </a>
                        </li>
                        <li>
                            <a href="admin_graficas.php">
                                <span class="material-symbols-outlined">
                                    Monitoring
                                </span>
                                <span class="title">Graficas</span>
                            </a>
                        </li>
                        <li>
                            <a href="dashboard.php">
                                <span class="material-symbols-outlined full">
                                    dashboard
                                </span>
                                <span class="title">Tablero</span>
                            </a>
                        </li>
                        <li>
                            <a href="generar_informe_admin.php">
                                <span class="material-symbols-outlined">
                                    Publish
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
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Tarea</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Asignado a</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($task = $result_tasks->fetch_assoc()) { ?>
                            <tr>
                                <form method="post" action="">
                                    <td><?php echo $task['id']; ?><input type="hidden" name="task_id" value="<?php echo $task['id']; ?>"></td>
                                    <td><input type="text" name="task_name" value="<?php echo $task['task_name']; ?>"></td>
                                    <td><input type="text" name="description" value="<?php echo $task['description']; ?>"></td>
                                    <td>
                                        <select name="status">
                                            <option value="pendiente" <?php if ($task['status'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                                            <option value="en progreso" <?php if ($task['status'] == 'en progreso') echo 'selected'; ?>>En Progreso</option>
                                            <option value="finalizado" <?php if ($task['status'] == 'finalizado') echo 'selected'; ?>>Finalizado</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="assigned_to">
                                            <?php foreach ($users as $user_id => $username) { ?>
                                                <option value="<?php echo $user_id; ?>" <?php if ($task['assigned_to'] == $user_id) echo 'selected'; ?>><?php echo $username; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="action-buttons">
                                        <button type="submit" name="edit_task" class="edit-btn">Editar</button>
                                        <button type="submit" name="delete_task" class="delete-btn" onclick="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">Eliminar</button>
                                    </td>
                                </form>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

</body>

</html>