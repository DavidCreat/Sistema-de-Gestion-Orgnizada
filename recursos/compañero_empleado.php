<?php
session_start();
include '../recursos/funcionalidad/php/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$query = "
    SELECT u.username, g.group_name, COUNT(t.id) as task_count
    FROM users u
    LEFT JOIN group_assignments ga ON u.id = ga.user_id
    LEFT JOIN groups g ON ga.group_id = g.id
    LEFT JOIN tasks t ON u.id = t.assigned_to
    GROUP BY u.id, g.group_name
";
$result = $conn->query($query);
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
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
        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-height: 400px;
            overflow-y: auto;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        canvas#tasksChart {
            max-width: 500px;
            max-height: 300px;
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
                            <a href="chat_empleado.php">
                                <span class="material-symbols-outlined">
                                    chat_bubble
                                </span>
                                <span class="title">Mensaje</span>
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
                <h2>Usuarios y Tareas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Grupo</th>
                            <th>Número de Tareas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['group_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['task_count']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2>Gráfica de Tareas por Usuario</h2>
                <canvas id="tasksChart"></canvas>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('tasksChart').getContext('2d');
                    const tasksChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode(array_column($users, 'username')); ?>,
                            datasets: [{
                                label: 'Número de Tareas',
                                data: <?php echo json_encode(array_column($users, 'task_count')); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </main>
        </div>
    </div>

    <script src="../recursos/funcionalidad/js/dashboardfront.js"></script>
</body>

</html>