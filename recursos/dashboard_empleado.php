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
</head>

<body>

    <style>
        .container .right main {
            position: relative;
            width: 100%;
            height: calc(91% - 41px);
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            grid-template-rows: repeat(3, 1fr);
            gap: 20px;
        }
    </style>
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
                <div class="projectCard">
                    <div class="projectTop">
                        <h2>Nombre de grupo<br><span><?php echo $group_name; ?></span></h2>

                    </div>
                    <div class="projectProgress">
                        <div class="process">
                            <h2>En Progreso</h2>
                        </div>
                        <div class="priority">
                            <h2>Alta Prioridad</h2>
                        </div>
                    </div>

                </div>
                <style>
                    .tasksHead {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 10px;
                    }

                    .tasksHead h2 {
                        font-size: 1.5rem;
                        color: #333;
                    }

                    .tasksDots {
                        cursor: pointer;
                    }

                    .tasks {
                        background-color: #fff;
                        border-radius: 6px;
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                        padding: 10px;
                    }

                    .taskItem {
                        margin-bottom: 10px;
                    }

                    .tasksName {
                        font-weight: bold;
                        color: #007bff;
                    }

                    .taskDescription {
                        color: #666;
                    }
                </style>
                <div class="myTasks">
                    <div class="tasksHead">
                        <h2>Mis Tareas</h2>
                        <div class="tasksDots">
                            <span class="material-symbols-outlined">
                                more_horiz
                            </span>
                        </div>
                    </div>
                    <div class="tasks">
                        <ul>
                            <?php foreach ($tareas as $tarea) : ?>
                                <li>
                                    <div class="taskItem">
                                        <span class="tasksName">
                                            <?php echo htmlspecialchars($tarea['task_name']); ?>
                                        </span>
                                        <p class="taskDescription">
                                            <?php echo htmlspecialchars($tarea['description']); ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>


                </div>


                <div class="calendar" bis_skin_checked="1">
                    <div class="calendarHead" bis_skin_checked="1">
                        <h2 id="monthYear">Junio 2024</h2>
                        <div class="calendarIcon" bis_skin_checked="1">
                            <span class="material-symbols-outlined" id="prevMonth">
                                chevron_left
                            </span>
                            <span class="material-symbols-outlined" id="nextMonth">
                                chevron_right
                            </span>
                        </div>
                    </div>
                    <div class="calendarData" bis_skin_checked="1">
                        <ul class="weeks">
                            <li>Dom</li>
                            <li>Lun</li>
                            <li>Mar</li>
                            <li>Mié</li>
                            <li>Jue</li>
                            <li>Vie</li>
                            <li>Sáb</li>
                        </ul>
                        <ul class="days" id="calendarDays">
                            <li class="inactive"></li>
                            <li class="inactive"></li>
                            <li class="inactive"></li>
                            <li class="inactive"></li>
                            <li class="inactive"></li>
                            <li class="inactive"></li>
                            <li class="active">1</li>
                            <li class="active">2</li>
                            <li class="active">3</li>
                            <li class="active">4</li>
                            <li class="active">5</li>
                            <li class="active">6</li>
                            <li class="active">7</li>
                            <li class="active">8</li>
                            <li class="active">9</li>
                            <li class="active">10</li>
                            <li class="active">11</li>
                            <li class="active">12</li>
                            <li class="active">13</li>
                            <li class="active">14</li>
                            <li class="active">15</li>
                            <li class="active">16</li>
                            <li class="active">17</li>
                            <li class="active today">18</li>
                            <li class="active">19</li>
                            <li class="active">20</li>
                            <li class="active">21</li>
                            <li class="active">22</li>
                            <li class="active">23</li>
                            <li class="active">24</li>
                            <li class="active">25</li>
                            <li class="active">26</li>
                            <li class="active">27</li>
                            <li class="active">28</li>
                            <li class="active">29</li>
                            <li class="active">30</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../recursos/funcionalidad/js/dashboardfront.js"></script>
</body>

</html>