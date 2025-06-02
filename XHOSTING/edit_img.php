<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "Usuario no autenticado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagen"])) {
    $id = $_SESSION["usuario_id"];
    $imagen = $_FILES["imagen"]["tmp_name"];

    if (!empty($imagen)) {
        $imagenBinaria = file_get_contents($imagen);

        // Actualizar la imagen en la base de datos
        $stmt = $conn->prepare("UPDATE usuario SET imagen = ? WHERE id = ?");
        $stmt->bind_param("si", $imagenBinaria, $id);

        if ($stmt->execute()) {
            $stmt->close();

            // Obtener la imagen actualizada desde la base de datos
            $stmt = $conn->prepare("SELECT imagen FROM usuario WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($imagenActualizada);
            $stmt->fetch();

            // Actualizar imagen en sesión como base64
            $_SESSION['usuario_imagen'] = base64_encode($imagenActualizada);

            $stmt->close();
            $conn->close();

            // Redirigir al index
            header("Location: index.php");
            exit;
        } else {
            echo "Error al actualizar la imagen: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Archivo de imagen vacío.";
    }
} else {
    echo "Petición incorrecta o archivo no enviado.";
}
?>
