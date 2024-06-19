<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGO</title>
    <link rel="stylesheet" href="./css/dashboard_admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                                <span class="material-symbols-outlined full">
                                    dashboard
                                </span>
                                <span class="title">Tablero</span>
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
                            <a href="admin_tareas.php">
                                <span class="material-symbols-outlined">
                                    task
                                </span>
                                <span class="title">Tareas creadas</span>
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


                <div class="timeline">
                    <div class="timelineHead">
                        <h2>Grupos Activos</h2>
                        <div class="timelineDots">
                            <span class="material-symbols-outlined">
                                Info
                            </span>
                        </div>
                    </div>
                    <div class="gruposActivos">
                        <ul>
                            <?php
                            include '../recursos/funcionalidad/php/db_connection.php';
                            $sql = "SELECT id, group_name FROM groups";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li>';
                                    echo '<span class="videoText">';
                                    echo '<span class="material-symbols-outlined full">Groups_2</span>';
                                    echo '<span class="text">' . htmlspecialchars($row['group_name']) . '</span>';
                                    echo '</span>';
                                    echo '<span class="timelineTime">Activo</span>';
                                    echo '</li>';
                                }
                            } else {
                                echo '<li>No hay grupos activos</li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <form method="POST" action="../recursos/funcionalidad/php/create_group.php">
                        <h3>Crear Grupo</h3>
                        <input type="text" name="group_name" placeholder="Nombre del Grupo" required>
                        <button type="submit" name="create_group">Crear Grupo</button>
                    </form>
                </div>
                <form class="create-usergroup-form" method="POST" action="funcionalidad/php/assign_to_group.php">
                    <h3>Asignar Persona a Grupo</h3>
                    <select name="user_id">
                        <?php
                        include '../recursos/funcionalidad/php/db_connection.php';
                        $result = $conn->query("SELECT id, username FROM users");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                        }
                        ?>
                    </select>
                    <select name="group_id">
                        <?php
                        $result = $conn->query("SELECT id, group_name FROM groups");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['group_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" name="assign_to_group">Asignar a Grupo</button>
                </form>


                <div class="create-user-form">
                    <form method="POST" action="../recursos/funcionalidad/php/create_user.php">
                        <h3>Crear Usuario</h3>
                        <button type="submit" name="create_random_user">Crear Usuario Aleatorio</button>
                    </form>
                </div>

                <div class="assign-task-form">
                    <form method="POST" action="../recursos/funcionalidad/php/assign_task.php">
                        <h3>Asignar Tarea</h3>
                        <input type="text" name="task_name" placeholder="Nombre de la Tarea" required>
                        <textarea name="description" placeholder="Descripción" required></textarea>
                        <select name="assigned_to" required>
                            <?php
                            include '../recursos/funcionalidad/php/db_connection.php';
                            $result = $conn->query("SELECT id, username FROM users WHERE role_id = 2");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" name="assign_task">Asignar Tarea</button>
                    </form>
                </div>

                <div class="calendar">
                    <div class="calendarHead">
                        <h2 id="monthYear"></h2>
                        <div class="calendarIcon">
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
                <div class="messages">
                    <div class="messagesHead">
                        <h2>Mensajes</h2>
                    </div>
                    <div class="chat-container">
                        <div class="chat-header">
                            <h2>Chat</h2>
                        </div>
                        <div class="chat-messages" id="chat-messages">
                            <!-- Mensajes se agregarán aquí -->
                        </div>
                        <div class="chat-input">
                            <input type="text" id="message-input" placeholder="Escribe un mensaje..." />
                            <button onclick="sendMessage()">Enviar</button>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="../recursos/funcionalidad/js/dashboardfront.js"></script>
    <script src="../recursos/funcionalidad/js/socket.js"></script>
</body>

</html>