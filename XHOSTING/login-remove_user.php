<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare("SELECT id, nombre, pass, imagen FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre, $hashed_pass, $imagen);
        $stmt->fetch();

        if (password_verify($pass, $hashed_pass)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nombre'] = $nombre;
            
            // Solo convertir la imagen si no está vacía
            if (!empty($imagen)) {
                $_SESSION['usuario_imagen'] = base64_encode($imagen);
            } else {
                $_SESSION['usuario_imagen'] = ""; // Imagen vacía
            }

            header("Location: remove_user.php"); // Redirigir a la página principal
            exit();
        } else {
            echo "Contraseña incorrecta <a href='index.php'>Inicio</a>";
        }
    } else {
        echo "Correo no encontrado <a href='index.php'>Inicio</a>";
    }

    $stmt->close();
    $conn->close();
}
?>