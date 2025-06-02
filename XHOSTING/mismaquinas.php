<?php

include 'header.php';

include 'db.php';
if (isset($_GET['id_maquina'])) {
    $_SESSION['id_maquina_editar'] = intval($_GET['id_maquina']);
}
?>


<main class="p6 maquinas-main">
    <?php
    // Si no hay sesión activa, mostramos el mensaje y detenemos la carga de máquinas
    if (!isset($_SESSION['usuario_id'])) {
        echo '<div class="acceso-denegado"><p>Acceso denegado. Por favor, <a href="login.html">inicia sesión</a>.</p></div>';
    } else {
        $id_usuario = $_SESSION['usuario_id'];
        $sql = "SELECT * FROM maquinas WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="maquina">
                    <div class="superior">
                        <div class="unerline">
                            <?= htmlspecialchars($row['nombre']) ?>
                        </div>
                        <div>
                            SO:<?= htmlspecialchars($row['so']) ?>
                        </div>
                    </div>
                    <div class="inferior1">
                        <div class="hardware">
                            <img src="img/icono-cpu.png" alt="">
                            <?= $row['cpu'] ?>
                            <img src="img/icono-ram.png" alt="">
                            <?= $row['ram'] ?>
                            <img src="img/icono-hdd.png" alt="">
                            <?= $row['disco'] ?>
                        </div>
                        <div class="botones-maquina">
                            <form action="iniciar_maquina.php">
                                <input type="hidden" name="id_maquina" value="<?= $row['id'] ?>">
                                <button class="iniciar-maquina" type="submit">Iniciar</button>
                            </form>
                            <form action="apagar_maquina.php">
                                <input type="hidden" name="id_maquina" value="<?= $row['id'] ?>">
                                <button class="apagar-maquina" type="submit">Apagar</button>
                            </form>
                            
                        </div>
                    </div>
                    <div class="inferior2">
                        <div class="monitorizacion-maquina">
                        <div>Monitorización 24H: <?= $row['monitorizacion'] == 1 ? '<span style="color: green; font-weight: bolder;">✓</span>' : '<span style="color: red; font-weight: bold;">✘</span>' ?></div>
                        </div>
                        <div>
                            <form action="reiniciar_maquina.php">
                                <input type="hidden" name="id_maquina" value="<?= $row['id'] ?>">
                                <button class="reiniciar-maquina" type="submit">Reiniciar</button>
                            </form>
                        </div>
                    </div>
                    <div class="inferior2">
                        <div class="asistencia-maquina">
                            <div>Asistencia Técnica: <?= $row['asistenciatecnica'] == 1 ? '<span style="color: green; font-weight: bolder;">✓</span>' : '<span style="color: red; font-weight: bold;">✘</span>' ?></div>
                        </div>
                        <div>
                            <form action="editar_maquina.php" method="get" style="display:inline;">
                                <input type="hidden" name="id_maquina" value="<?= $row['id'] ?>">
                                <button class="editar-maquina" type="submit">Editar Máquina</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes máquinas asociadas.</p>
        <?php endif;

        $stmt->close();
    }
    $conn->close();
    ?>
</main>

<footer>
    <p>Copyright © 2025 Xhosting. Todos los derechos reservados.</p>
    <a href="#top"><img src="img/top.jpg" alt="Subir al principio"></a>
</footer>

</body>
</html>
