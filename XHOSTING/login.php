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

            if (!empty($imagen)) {
                // Codificamos la imagen a base64 antes de guardarla en la sesión
                $_SESSION['usuario_imagen'] = base64_encode($imagen); 
            } else {
                $_SESSION['usuario_imagen'] = ""; // Si no tiene imagen, lo dejamos vacío
            }

            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta <a href='login.html'>Intentar de nuevo</a>";
        }
    } else {
        echo "Correo no encontrado <a href='login.html'>Intentar de nuevo</a>";
    }

    $stmt->close();
    $conn->close();
}
?>
