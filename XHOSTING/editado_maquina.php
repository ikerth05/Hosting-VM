<?php
session_start();
include("db.php");

if (!isset($_SESSION['id_maquina_editar'])) {
    die("Error: No se proporcionó el ID de la máquina.");
}

$id_maquina = $_SESSION['id_maquina_editar'];

// Obtener los valores actuales de la máquina
$sql = "SELECT ram, cpu, disco, asistenciatecnica, monitorizacion, nombre, so FROM maquinas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_maquina);
$stmt->execute();
$result = $stmt->get_result();

if ($fila = $result->fetch_assoc()) {
    $ram_actual   = $fila['ram'];
    $cpu_actual   = $fila['cpu'];
    $disco_actual = $fila['disco'];
    $asistencia_tecnica_actual = $fila['asistenciatecnica'];
    $monitorizacion_actual     = $fila['monitorizacion'];
    $nombre_maquina_actual     = $fila['nombre'];
    $so_actual                 = $fila['so'];
} else {
    die("Error: Máquina no encontrada.");
}

// Obtener los datos del formulario (POST)
$nombre_maquina = isset($_POST['nombre_maquina']) ? $_POST['nombre_maquina'] : $nombre_maquina_actual;
$sistema = isset($_POST['sistema'][0]) ? $_POST['sistema'][0] : $so_actual;
$ram_nueva = isset($_POST['ram'][0]) ? $_POST['ram'][0] : 0;
$cpu_nuevo = isset($_POST['cpu'][0]) ? $_POST['cpu'][0] : 0;
$disco_nuevo = isset($_POST['disco'][0]) ? $_POST['disco'][0] : 0;
$asistencia_tecnica = isset($_POST['asistenciatecnica'][0]) ? intval($_POST['asistenciatecnica'][0]) : $asistencia_tecnica_actual;
$monitorizacion = isset($_POST['monitorizacion'][0]) ? intval($_POST['monitorizacion'][0]) : $monitorizacion_actual;

// Sumar los valores de RAM, CPU y Disco
$ram_total = $ram_actual + $ram_nueva;
$cpu_total = $cpu_actual + $cpu_nuevo;
$disco_total = $disco_actual + $disco_nuevo;

// Actualizar los datos en la base de datos
$sql_update = "UPDATE maquinas SET 
    nombre = ?, 
    so = ?, 
    ram = ?, 
    cpu = ?, 
    disco = ?, 
    asistenciatecnica = ?, 
    monitorizacion = ? 
  WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
if (!$stmt_update) {
    die("Error en prepare: " . $conn->error);
}

// Cadena de tipos: "ssiiiiii" (8 variables)
$stmt_update->bind_param(
    "ssiiiiii",
    $nombre_maquina,
    $sistema,
    $ram_total,
    $cpu_total,
    $disco_total,
    $asistencia_tecnica,
    $monitorizacion,
    $id_maquina
);

// Ejecutar la actualización
if ($stmt_update->execute()) {
    header("Location: mismaquinas.php");
} else {
    echo "Error al actualizar la máquina: " . $stmt_update->error;
}

$stmt_update->close();
$conn->close();
?>
