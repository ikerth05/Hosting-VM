<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acceso no autorizado");
}

$id = $_SESSION['usuario_id'];

// Eliminar las máquinas primero (por integridad referencial)
$stmt1 = $conn->prepare("DELETE FROM maquinas WHERE id_usuario = ?");
$stmt1->bind_param("i", $id);
$stmt1->execute();
$stmt1->close();

// Luego eliminar el usuario
$stmt2 = $conn->prepare("DELETE FROM usuario WHERE id = ?");
$stmt2->bind_param("i", $id);

if ($stmt2->execute()) {
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    echo "Error al eliminar la cuenta";
}

$stmt2->close();
$conn->close();
?>