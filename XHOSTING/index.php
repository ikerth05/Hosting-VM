<?php
    include 'header.php';
?>
        
        <main class='main-index'>
            <div class="inicio-index">
                <div class="ver-planes">
                    <p>HOSTING WEB <span class="texto-texto">Sin Permanencia</span></p>
                    <h2>Hosting ilimitado, fiabilidad, seguro, rápido y accesible</h2>
                    <h4>Podrás incluir monitorización H24 a tus máquinas, recibir alertas personalizadas, asesoramiento técnico para la optimización de la máquina y contacto rápido por parte técnica en caso de falla</h4>
                    <h3>Promoción <span class="4'99">4'99</span> €/mes</h3>
                    <a href="#planes"><button>VER PLANES</button></a>
                </div>
                <div class="imagen_index">
                    <img src="img/xhosting_imagen_index.jpg" alt="">
                </div>
                <div class="imagen_index2">
                    <img src="img/virtual-hosting-services.png" alt="">
                </div>
                <div class="imagen_index3">
                    <img src="img/Xhosting_logo_logo.png" alt="">
                </div>
            </div>
            <h2 id="planes" class="titulo">PLANES</h2>
            <?php
            $enlaceBasico = isset($_SESSION['usuario_id']) ? 'adquirirbasico.php' : 'login.html';
            $enlaceAsistencia = isset($_SESSION['usuario_id']) ? 'adquirirasistencia.php' : 'login.html';
            $enlaceEmpresas = isset($_SESSION['usuario_id']) ? 'adquirirempresas.php' : 'login.html';
            ?>
            <div class="contenedor-tarifas">
                <div class="tarifa">
                    <h2>Básico</h2>
                    <ul>
                        <li class="tick">De 1 a 4 máquinas</li>
                        <li class="tick">Personalización del Hardware</li>
                        <li class="tick">Personalización del SO</li>
                        <li class="cross">-10% por máquina</li>
                        <li class="cross">Asistencia técnica para su gestión</li>
                        <li class="complementario">Monitorización H24 con envio de alertas personalizada</li>
                    </ul>
                    <br>
                    <a href="<?php echo $enlaceBasico; ?>"><button>Adquirir</button></a>
                </div>
                <div class="tarifa">
                    <h2>Tarifa asistencia</h2>
                    <ul>
                        <li class="tick">De 1 a 4 máquinas</li>
                        <li class="tick">Personalización del Hardware</li>
                        <li class="tick">Personalización del SO</li>
                        <li class="cross">-10% por máquina</li>
                        <li class="tick">Asistencia técnica para su gestión</li>
                        <li class="complementario">Monitorización H24 con envio de alertas personalizada</li>
                    </ul>
                    <br>
                    <a href="<?php echo $enlaceAsistencia; ?>"><button>Adquirir</button></a>
                </div>
                <div class="tarifa">
                    <h2>Empresas</h2>
                    <ul>
                        <li class="tick">5 o más máquinas</li>
                        <li class="tick">Personalización del Hardware</li>
                        <li class="tick">Personalización del SO</li>
                        <li class="tick">-10% por máquina</li>
                        <li class="complementario">Asistencia técnica para su gestión</li>
                        <li class="complementario">Monitorización H24 con envio de alertas personalizada</li>
                    </ul>
                    <br>
                    <a href="<?php echo $enlaceEmpresas; ?>"><button>Adquirir</button></a>
                </div>
            </div>
        </main>
        
        <footer>
            <p>Copyright © 2025 Xhosting. Todos los derechos reservados.</p>
            <a href="#top"><img src="img/top.jpg" alt=""></a>
        </footer>
    </body>
</html>
