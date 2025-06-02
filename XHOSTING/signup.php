<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telf = $_POST['telf'];
    $pass = $_POST['pass'];
    $pass_confirm = $_POST['pass_confirm'];

    // Verificar si las contraseñas coinciden
    if ($pass !== $pass_confirm) {
        echo "Las contraseñas no coinciden. <a href='index.php'>Ir al inicio</a>";
        exit;
    }

    // Verificar si el correo ya está registrado
    $stmt = $conn->prepare("SELECT id FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Este correo electrónico ya está en uso. <a href='index.php'>Ir al inicio</a>";
        exit;
    }
    $stmt->close();

    // Verificar si el teléfono ya está registrado
    $stmt = $conn->prepare("SELECT id FROM usuario WHERE telf = ?");
    $stmt->bind_param("s", $telf);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Este teléfono ya está en uso. <a href='index.php'>Ir al inicio</a>";
        exit;
    }
    $stmt->close();

    // Encriptar la contraseña
    $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

    // Verificar si hay imagen subida
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Si hay una imagen, guardarla
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
    } else {
        // Si no hay imagen, usar una predeterminada
        $imagen = file_get_contents('img/default-user.jpg'); 
    }

    // Insertar usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, telf, pass, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $nombre, $correo, $telf, $pass_hashed, $imagen);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit();
    } else {
        echo "Error al registrar el usuario. <a href='index.php'>Ir al inicio</a>";
    }

    $stmt->close();
    $conn->close();
}
?>
