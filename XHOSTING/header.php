<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
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
    <body>
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
            <script class="traductor" type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'es',
                        includedLanguages: 'ca,gl,eu,en,fr,pt,es',
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