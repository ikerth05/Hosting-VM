<?php
session_start();

if (isset($_GET['id_maquina'])) {
    $_SESSION['id_maquina_editar'] = intval($_GET['id_maquina']);
}

if (!isset($_SESSION['id_maquina_editar'])) {
    die("Error: No se proporcionó el ID de la máquina.");
}
$id_maquina = $_SESSION['id_maquina_editar'];

include("db.php");

$sql = "SELECT nombre, so, ram, cpu, disco, asistenciatecnica, monitorizacion 
        FROM maquinas 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_maquina);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $nombreMaquina      = htmlspecialchars($fila['nombre']);
    $sistemaOperativo   = $fila['so'];
    $ram                 = $fila['ram'];
    $cpu                 = $fila['cpu'];
    $disco               = $fila['disco'];
    $asistenciaTecnica   = $fila['asistenciatecnica'];
    $monitorizacion      = $fila['monitorizacion'];
} else {
    die("Máquina no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Xhosting</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="styles.css" rel="stylesheet">
        <link rel="icon" href="img/icono.svg" type="image/svg">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
    </head>
    <header id="top">
            <div>
                <a href="index.php">
                    <img class="imagenindex" src="img/reducido-chipblanco-bolaazul.svg" alt="ImagenLogo">
                </a>
            </div>
            <div class="h1-header">
                <h1>Xhosting</h1>
            </div>
            <div class="login">
                <?php
                    if (isset($_SESSION['usuario_id'])) {
                        $nombre = isset($_SESSION['usuario_nombre']) ? htmlspecialchars($_SESSION['usuario_nombre']) : "Usuario";
                        $imagen = isset($_SESSION['usuario_imagen']) ? $_SESSION['usuario_imagen'] : "";
                ?>
                    <div class='dropdown'>
                        <button class='dropbtn'>
                            <img src='data:image/jpeg;base64,<?php echo $imagen; ?>' width='40' height='40' style='border-radius: 50%;'>
                        </button>
                        <div class='dropdown-content'>
                            <p>Buenas, <?php echo $nombre; ?></p>
                            <a href='edit_user.html'>Editar usuario</a>
                            <a href='edit_img.html'>Editar icono</a>
                            <a href='logout.php'>Cerrar sesión</a>
                            <a href='login-remove_user.html' style='color: red;'>Eliminar usuario</a>
                        </div>
                    </div>
                <?php
                    } else {
                        echo '<a href="login.html">Login</a>';
                    }
                ?>
            </div>
            
            <!-- Traductor dentro del header -->
            <div id="google_translate_element" style="position: absolute; top: 10px; right: 10px;"></div>
            
            <!-- Script para cargar el widget de Google Translate -->
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'es',
                        includedLanguages: 'es,en,fr,de,it,ca',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                    }, 'google_translate_element');
                }
            </script>
            <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        </header>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="mismaquinas.php">Mis Maquinas</a>
        <a href="sobrenosotros.php">Sobre Nosotros</a>
        <a href="ubicacion.php">Ubicación</a>
    </nav>
    <body class="body-adquirir-tarifa">
    <main class="main-adquirir">
        <h2>Edita o mejora tu máquina</h2>
        <form id="configurador" method="post" action="editado_maquina.php">
                <div class="formularios-container-class" id="formularios-container">
                <div class="menu-compra" id="menu-compra-template">
                    <div>
                        <label for="nombre_maquina">Nombre de la Máquina:</label>
                        <input type="text" class="nombre_maquina" name="nombre_maquina" value="<?php echo $nombreMaquina; ?>" required>
                    </div>
                    <div>
                        <label for="sistema">Sistema Operativo:</label>
                        <select class="sistema" name="sistema[]" value="<?php echo $nombremaquina; ?>">
                            <option value="Sin-definir">Sin Definir</option>
                            <option value="Ubuntu Server">Ubuntu 22.04.5 LTS Server</option>
                            <option value="Ubuntu Desktop">Ubuntu 22.04.5 LTS Desktop</option>
                            <option value="Debian 12.0 LTS">Debian 12.0 LTS</option>
                            <option value="Windows Server 2019">Windows Server 2019</option>
                            <option value="Windows Server 2022">Windows Server 2022</option>
                            <option value="Windows Server 2025">Windows Server 2025</option>
                            <option value="Windows 10">Windows 10</option>
                            <option value="Windows 11">Windows 11</option>
                        </select>
                    </div>
                    <div>
                        <label>Memoria RAM (Max 64 GB):</label>
                        <input type="number" class="ram" name="ram[]" value="0" min="0" max="64">
                    </div>
                    <div>
                        <label>Cantidad de CPUs (Max 16 CPUs):</label>
                        <input type="number" class="cpu" name="cpu[]" value="0" min="0" max="16">
                    </div>
                    <div>
                        <label>Espacio en Disco (Max 2000 GB):</label>
                        <input type="number" class="disco" name="disco[]" value="0" min="0" max="2000">
                    </div>
                    <div <?php if ($asistenciaTecnica == 1) echo 'style="display:none;"'; ?>>
                        <label for="asistenciatecnica">Asistencia Técnica (+5€):</label>
                        <select class="asistenciatecnica" name="asistenciatecnica[]">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                    <div <?php if ($monitorizacion == 1) echo 'style="display:none;"'; ?>>
                        <label for="monitorizacion">Monitorización H24 + Alertas Personalizadas (+3€):</label>
                        <select class="monitorizacion" name="monitorizacion[]">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                    <div style="display: flex; justify-content: space-around; align-items: baseline;">
                        <div>
                            <h3>Total: €<span class="preciomaquina"></span></h3>
                        </div>
                        <div>
                            <button class="boton-comprar" type="submit">Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const precioRAM = 0.5;
                const precioCPU = 1.5;
                const precioDisco = 0.01;
                const precioMonitorizacion = 3;
                const precioAsistencia = 5; // Precio de la asistencia técnica

                const formulario = document.querySelector(".menu-compra");
                const precioMaquinaElement = formulario.querySelector(".preciomaquina");

                function calcularPrecio() {
                    const ram = parseInt(formulario.querySelector(".ram").value) || 0;
                    const cpu = parseInt(formulario.querySelector(".cpu").value) || 0;
                    const disco = parseInt(formulario.querySelector(".disco").value) || 0;
                    const monitorizacion = formulario.querySelector(".monitorizacion").value === "1" ? precioMonitorizacion : 0;
                    const asistenciaTecnica = formulario.querySelector(".asistenciatecnica").value === "1" ? precioAsistencia : 0; // Comprobamos asistencia técnica

                    const precio = (ram * precioRAM) + (cpu * precioCPU) + (disco * precioDisco) + monitorizacion + asistenciaTecnica;
                    precioMaquinaElement.textContent = precio.toFixed(2);
                }

                // Escuchar cambios
                formulario.querySelector(".ram").addEventListener("input", calcularPrecio);
                formulario.querySelector(".cpu").addEventListener("input", calcularPrecio);
                formulario.querySelector(".disco").addEventListener("input", calcularPrecio);
                formulario.querySelector(".monitorizacion").addEventListener("change", calcularPrecio);
                formulario.querySelector(".asistenciatecnica").addEventListener("change", calcularPrecio); // Escuchar cambios en la asistencia

                // Calcular al cargar la página
                calcularPrecio();
            });
        </script>
        <script>
            document.getElementById("configurador").addEventListener("submit", function(e) {
                // Recorremos todos los selects dentro del formulario
                this.querySelectorAll("select").forEach(function(select) {
                    const contenedor = select.closest("div");
                    if (contenedor && window.getComputedStyle(contenedor).display === "none") {
                        select.disabled = true;  // deshabilita para que no se envíe en el POST
                    }
                });
            });
        </script>

        <div id="resumen"></div>
    </main>
    <footer>
        <p>Copyright © 2025 Xhosting. Todos los derechos reservados.</p>
        <a href="#top"><img src="img/top.jpg" alt=""></a>
    </footer>
    </body>
</html>