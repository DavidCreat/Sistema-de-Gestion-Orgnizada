<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_random_user'])) {
    $username = generateRandomUsername();
    $password = generateRandomPassword();
    $role_id = 2;
    $sql = "INSERT INTO users (username, password, role_id) VALUES ('$username', '$password', '$role_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo usuario creado exitosamente<br>";
        echo "Nombre de usuario: $username<br>";
        echo "Contraseña: $password<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
/*

░██████╗░███████╗███╗░░██╗███████╗██████╗░░█████╗░░█████╗░██╗░█████╗░███╗░░██╗  ██████╗░███████╗
██╔════╝░██╔════╝████╗░██║██╔════╝██╔══██╗██╔══██╗██╔══██╗██║██╔══██╗████╗░██║  ██╔══██╗██╔════╝
██║░░██╗░█████╗░░██╔██╗██║█████╗░░██████╔╝███████║██║░░╚═╝██║██║░░██║██╔██╗██║  ██║░░██║█████╗░░
██║░░╚██╗██╔══╝░░██║╚████║██╔══╝░░██╔══██╗██╔══██║██║░░██╗██║██║░░██║██║╚████║  ██║░░██║██╔══╝░░
╚██████╔╝███████╗██║░╚███║███████╗██║░░██║██║░░██║╚█████╔╝██║╚█████╔╝██║░╚███║  ██████╔╝███████╗
░╚═════╝░╚══════╝╚═╝░░╚══╝╚══════╝╚═╝░░╚═╝╚═╝░░╚═╝░╚════╝░╚═╝░╚════╝░╚═╝░░╚══╝  ╚═════╝░╚══════╝

██╗░░░██╗░██████╗██╗░░░██╗░█████╗░██████╗░██╗░█████╗░
██║░░░██║██╔════╝██║░░░██║██╔══██╗██╔══██╗██║██╔══██╗
██║░░░██║╚█████╗░██║░░░██║███████║██████╔╝██║██║░░██║
██║░░░██║░╚═══██╗██║░░░██║██╔══██║██╔══██╗██║██║░░██║
╚██████╔╝██████╔╝╚██████╔╝██║░░██║██║░░██║██║╚█████╔╝
░╚═════╝░╚═════╝░░╚═════╝░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░╚════╝░____Generacion de usuario
*/
function generateRandomUsername($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomUsername = '';
    for ($i = 0; $i < $length; $i++) {
        $randomUsername .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomUsername;
}
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}
?>
