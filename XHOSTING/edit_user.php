<?php
session_start();
include 'db.php';

// Verificamos que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Usuario no autenticado. <a href='index.php'>Ir al inicio</a>";
    exit;
}

// Obtener el ID del usuario desde la sesión
$id = $_SESSION['usuario_id'];

// Comprobamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $telf = isset($_POST['telf']) ? $_POST['telf'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $pass_confirm = isset($_POST['pass_confirm']) ? $_POST['pass_confirm'] : '';

    // Verificar si el correo ya está en uso por otro usuario (excluyendo el usuario actual)
    if (!empty($correo)) {
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE correo = ? AND id != ?");
        $stmt->bind_param("si", $correo, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Este correo electrónico ya está en uso por otro usuario. <a href='index.php'>Ir al inicio</a>";
            exit;
        }

        $stmt->close();
    }

    // Verificar si el teléfono ya está en uso por otro usuario (excluyendo el usuario actual)
    if (!empty($telf)) {
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE telf = ? AND id != ?");
        $stmt->bind_param("si", $telf, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Este teléfono ya está en uso por otro usuario. <a href='index.php'>Ir al inicio</a>";
            exit;
        }

        $stmt->close();
    }

    // Iniciar la consulta de actualización
    $query = "UPDATE usuario SET ";
    $params = [];
    $types = "";

    // Solo añadimos los campos que no están vacíos
    if (!empty($nombre)) {
        $query .= "nombre = ?, ";
        $params[] = $nombre;
        $types .= "s";
    }

    if (!empty($correo)) {
        $query .= "correo = ?, ";
        $params[] = $correo;
        $types .= "s";
    }

    if (!empty($telf)) {
        $query .= "telf = ?, ";
        $params[] = $telf;
        $types .= "s";  // o "i" si quieres forzar un entero
    }

    if (!empty($pass)) {
        if ($pass === $pass_confirm) {
            $query .= "pass = ?, ";
            $params[] = password_hash($pass, PASSWORD_BCRYPT);
            $types .= "s";
        } else {
            echo "Las contraseñas no coinciden. <a href='index.php'>Ir al inicio</a>";
            exit;
        }
    }

    // Quitamos la coma final
    $query = rtrim($query, ", ");

    // Agregamos la condición WHERE
    $query .= " WHERE id = ?";

    // Añadimos el ID del usuario
    $params[] = $id;
    $types .= "i";  // ID es un entero

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // Si se actualiza correctamente, actualizamos los datos en la sesión
        if (!empty($nombre)) {
            $_SESSION['usuario_nombre'] = $nombre;
        }

        if (!empty($correo)) {
            $_SESSION['usuario_correo'] = $correo;
        }

        if (!empty($telf)) {
            $_SESSION['usuario_telf'] = $telf;
        }

        // Si también se cambió la contraseña, la sesión no necesita actualizarse porque ya está cifrada.
        // Pero si quieres actualizarla explícitamente:
        if (!empty($pass)) {
            $_SESSION['usuario_pass'] = $pass;
        }

        header("Location: index.php");  // Redirige a la página principal
        exit;
    } else {
        echo "Error al actualizar la cuenta: " . $stmt->error . " <a href='index.php'>Ir al inicio</a>";
    }

    $stmt->close();
    $conn->close();
}
?>
