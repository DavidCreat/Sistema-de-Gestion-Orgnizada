<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGO</title>
    <link rel="stylesheet" href="./css/dashboard_admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .charts-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .chart-container {
            position: relative;
            width: 100%;
            max-width: 437px;
            margin: 16px;
            background: #fff;
            padding: 20px;
            border-radius: 17px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }
    </style>
</head>

<body>

    <?php
    include '../recursos/funcionalidad/php/db_connection.php';
    $result_users = $conn->query("SELECT COUNT(*) AS total_users FROM users");
    $total_users = $result_users->fetch_assoc()['total_users'];
    $result_groups = $conn->query("SELECT COUNT(*) AS total_groups FROM groups");
    $total_groups = $result_groups->fetch_assoc()['total_groups'];
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
                <div class="charts-wrapper">
                    <div class="chart-container">
                        <canvas id="usersChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="groupsChart"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctxUsers = document.getElementById('usersChart').getContext('2d');
            var usersChart = new Chart(ctxUsers, {
                type: 'bar',
                data: {
                    labels: ['Usuarios'],
                    datasets: [{
                        label: 'Cantidad de Usuarios',
                        data: [<?php echo $total_users; ?>],
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
            var ctxGroups = document.getElementById('groupsChart').getContext('2d');
            var groupsChart = new Chart(ctxGroups, {
                type: 'pie',
                data: {
                    labels: ['Grupos'],
                    datasets: [{
                        label: 'Distribución de Grupos',
                        data: [<?php echo $total_groups; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#333',
                            bodyColor: '#666',
                            borderColor: '#ddd',
                            borderWidth: 1
                        }
                    }
                }
            });
        });
    </script>

    <script src="../recursos/funcionalidad/js/dashboardfront.js"></script>
</body>

</html>