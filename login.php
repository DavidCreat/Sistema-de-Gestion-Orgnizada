<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="recursos/css/login.css">
</head>

<body>
    <div class="background"></div>
    <div class="login-card">
        <h2>Iniciar Sesión</h2>
        <?php
        session_start();
        include 'recursos/funcionalidad/php/db_connection.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: recursos/dashboard_empleado.php');
                    exit();
                } else {
                    echo '<div style="color: red; margin-bottom: 10px;">Nombre de usuario o contraseña incorrectos.</div>';
                }
            } else {
                echo '<div style="color: red; margin-bottom: 10px;">Nombre de usuario o contraseña incorrectos.</div>';
            }
        }
        ?>
        <form action="#" method="post">
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Usuario" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
        <button><a href="index.html">Volver al Inicio</a></button>
    </div>
</body>

</html>
