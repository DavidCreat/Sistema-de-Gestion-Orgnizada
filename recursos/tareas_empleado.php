<?php
session_start();
include '../recursos/funcionalidad/php/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
function getStatusClass($status)
{
    switch ($status) {
        case 'pendiente':
            return ['class' => 'status-pending', 'label' => 'Pendiente'];
        case 'en progreso':
            return ['class' => 'status-en-progreso', 'label' => 'En Progreso'];
        case 'finalizado':
            return ['class' => 'status-finalizado', 'label' => 'Finalizado'];
        default:
            return ['class' => '', 'label' => ''];
    }
}
$query = "
    SELECT 
        t.id AS task_id,
        t.task_name,
        t.description,
        t.status,
        g.group_name
    FROM tasks t
    LEFT JOIN group_assignments ga ON t.assigned_to = ga.user_id
    LEFT JOIN groups g ON ga.group_id = g.id
    WHERE t.assigned_to = $user_id
";
$result = $conn->query($query);
$user_tasks = [];
while ($row = $result->fetch_assoc()) {
    $user_tasks[] = $row;
}
$count_query = "
    SELECT 
        SUM(CASE WHEN t.status = 'Pendiente' THEN 1 ELSE 0 END) as pendiente_count,
        SUM(CASE WHEN t.status = 'En Progreso' THEN 1 ELSE 0 END) as en_progreso_count,
        SUM(CASE WHEN t.status = 'Finalizado' THEN 1 ELSE 0 END) as finalizado_count,
        g.group_name
    FROM tasks t
    LEFT JOIN group_assignments ga ON t.assigned_to = ga.user_id
    LEFT JOIN groups g ON ga.group_id = g.id
    WHERE t.assigned_to = $user_id
    GROUP BY g.group_name
";
$count_result = $conn->query($count_query);
$task_counts = [];
while ($row = $count_result->fetch_assoc()) {
    $task_counts[$row['group_name']] = [
        'pendiente_count' => $row['pendiente_count'],
        'en_progreso_count' => $row['en_progreso_count'],
        'finalizado_count' => $row['finalizado_count'],
    ];
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
        .container .right main {
            position: relative;
            width: 100%;
            height: calc(91% - 41px);
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 20px;
        }

        main {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .tasks {
            flex: 1 1 70%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: auto;
            max-height: 862px;
            margin-right: 1px;
            margin-top: 20px;
        }

        .chart {
            flex: 1 1 30%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .task-item {
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            position: relative;
        }

        .task-item h3 {
            margin-bottom: 5px;
            font-size: 16px;
        }

        .task-item p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .task-status {
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-pending {
            color: orange;
            background-color: #fce8d8;
        }

        .status-en-progreso {
            color: blue;
            background-color: #d8eaff;
        }

        .status-finalizado {
            color: green;
            background-color: #d8f7dc;
        }

        .task-menu {
            display: none;
            position: absolute;
            z-index: 100;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .task-menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .task-menu ul li {
            margin-bottom: 5px;
        }

        .task-menu ul li a {
            display: block;
            padding: 5px 10px;
            text-decoration: none;
            color: #333;
        }

        .task-menu ul li a:hover {
            background-color: #f0f0f0;
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
                                    task
                                </span>
                                <span class="title">Mis Tareas</span>
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
                            <a href="compañero_empleado.php">
                                <span class="material-symbols-outlined">
                                    group
                                </span>
                                <span class="title">Mis Compañeros</span>
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
                <div class="tasks">
                    <h2>Mis Tareas</h2>
                    <?php foreach ($user_tasks as $task) : ?>
                        <div class="task-item" data-task-id="<?php echo $task['task_id']; ?>">
                            <h3><?php echo htmlspecialchars($task['task_name']); ?></h3>
                            <p><?php echo htmlspecialchars($task['description']); ?></p>
                            <?php $status_class = getStatusClass($task['status']); ?>
                            <span class="task-status <?php echo $status_class['class']; ?>"><?php echo $status_class['label']; ?></span>
                            <div class="task-menu">
                                <ul>
                                    <li><a href="#" data-status="Pendiente">Marcar como Pendiente</a></li>
                                    <li><a href="#" data-status="En Progreso">Marcar como En Progreso</a></li>
                                    <li><a href="#" data-status="Finalizado">Marcar como Finalizado</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="chart">
                    <h2>Gráfica de Tareas por Usuario</h2>
                    <canvas id="tasksChart"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    function getStatusClass(status) {
                        switch (status) {
                            case 'Pendiente':
                                return {
                                    class: 'status-pending', label: 'Pendiente'
                                };
                            case 'En Progreso':
                                return {
                                    class: 'status-en-progreso', label: 'En Progreso'
                                };
                            case 'Finalizado':
                                return {
                                    class: 'status-finalizado', label: 'Finalizado'
                                };
                            default:
                                return {
                                    class: '', label: ''
                                };
                        }
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        const taskItems = document.querySelectorAll('.task-item');

                        taskItems.forEach(function(taskItem) {
                            taskItem.addEventListener('click', function(event) {
                                // Toggle para mostrar/ocultar el menú de opciones al hacer clic en la tarea
                                const taskMenu = taskItem.querySelector('.task-menu');
                                taskMenu.style.display = (taskMenu.style.display === 'block' ? 'none' : 'block');
                            });

                            const taskMenuLinks = taskItem.querySelectorAll('.task-menu a');
                            taskMenuLinks.forEach(function(link) {
                                link.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const newStatus = link.getAttribute('data-status');
                                    const taskId = taskItem.getAttribute('data-task-id');
                                    const formData = new FormData();
                                    formData.append('task_id', taskId);
                                    formData.append('new_status', newStatus);

                                    fetch('funcionalidad/php/update_task_status.php', {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            const taskStatus = taskItem.querySelector('.task-status');
                                            const statusClass = getStatusClass(newStatus);
                                            taskStatus.textContent = statusClass.label;
                                            taskStatus.className = 'task-status ' + statusClass.class;
                                            const taskMenu = taskItem.querySelector('.task-menu');
                                            taskMenu.style.display = 'none';
                                        })
                                        .catch(error => {
                                            console.error('Error al actualizar el estado:', error);
                                            alert('Hubo un error al intentar actualizar el estado de la tarea.');
                                        });
                                });
                            });
                        });
                        const ctx = document.getElementById('tasksChart').getContext('2d');
                        const tasksChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode(array_keys($task_counts)); ?>,
                                datasets: [{
                                        label: 'Pendiente',
                                        data: <?php echo json_encode(array_column($task_counts, 'pendiente_count')); ?>,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'En Progreso',
                                        data: <?php echo json_encode(array_column($task_counts, 'en_progreso_count')); ?>,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Finalizado',
                                        data: <?php echo json_encode(array_column($task_counts, 'finalizado_count')); ?>,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>
            </main>
</body>

</html>