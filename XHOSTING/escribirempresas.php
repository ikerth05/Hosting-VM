<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario_id'])) {
        echo "Error: Usuario no autenticado.";
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];

    // Obtener la cantidad de máquinas enviadas (debería ser igual al número de formularios)
    $num_maquinas = isset($_POST['cantidad_maquinas']) ? intval($_POST['cantidad_maquinas']) : 0;

    // Comprobar que num_maquinas es mayor que 0
    if ($num_maquinas <= 0) {
        echo "Error: La cantidad de máquinas es incorrecta.";
        exit();
    }

    // Recorrer los datos de cada formulario enviado
    for ($i = 0; $i < $num_maquinas; $i++) {
        if (isset($_POST['nombre_maquina'][$i]) && isset($_POST['sistema'][$i]) && isset($_POST['ram'][$i]) && isset($_POST['cpu'][$i]) && isset($_POST['disco'][$i]) && isset($_POST['monitorizacion'][$i])) {
            $nombre_maquina = $_POST['nombre_maquina'][$i]; // Recoge el nombre del formulario
            $so = $_POST['sistema'][$i];
            $cpu = intval($_POST['cpu'][$i]);
            $ram = intval($_POST['ram'][$i]);
            $disco = intval($_POST['disco'][$i]);
            $asistenciatecnica = intval($_POST['asistenciatecnica'][$i]);
            $monitorizacion = intval($_POST['monitorizacion'][$i]);

            // Preparar la consulta para insertar la máquina
            $stmt_maquinas = $conn->prepare("INSERT INTO maquinas (nombre, so, cpu, ram, disco, asistenciatecnica, monitorizacion, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_maquinas->bind_param("ssiiisis", $nombre_maquina, $so, $cpu, $ram, $disco, $asistenciatecnica, $monitorizacion, $usuario_id);

            // Ejecutar la consulta y verificar si fue exitosa
            if (!$stmt_maquinas->execute()) {
                echo "Error al insertar la máquina " . ($i + 1) . ": " . $stmt_maquinas->error . "<br>";
            }
            $stmt_maquinas->close();
        } else {
            echo "Error: Faltan datos en el formulario de la máquina " . ($i + 1) . ".<br>";
        }
    }

    // Actualizar el plan del usuario a "asistencia"
    $stmt_usuario = $conn->prepare("UPDATE usuario SET plan = 'empresas' WHERE id = ?");
    $stmt_usuario->bind_param("i", $usuario_id);

    if ($stmt_usuario->execute()) {
        header("Location: metodo_de_pago.php");
    } else {
        echo "Error al actualizar el plan del usuario: " . $stmt_usuario->error . "<br>";
    }

    $stmt_usuario->close();
    $conn->close();

} else {
    echo "Acceso no permitido.";
}
?>