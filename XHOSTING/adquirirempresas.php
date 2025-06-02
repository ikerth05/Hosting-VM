<?php
    include 'header.php';
?>
    <body class="body-adquirir-tarifa">
    <main class="main-adquirir">
        <h2>Tarifa Empresas</h2>
        <form id="configurador" action="escribirempresas.php" method="POST">
            <div class="cantidad-maquinas">
                <label for="maquinas">Número de Máquinas Virtuales:</label>
                <input type="number" id="maquinas" name="cantidad_maquinas" value="5" min="5">
            </div>       

            <div class="formularios-container-class" id="formularios-container">
                <!-- Este div será clonado dinámicamente -->
                <div class="menu-compra plantilla" style="display:none;">
                <div>
                    <label>Nombre de la Máquina:</label>
                    <input type="text" name="nombre_maquina[]" value="Máquina" required>
                </div>
                    <div>
                        <label for="sistema">Sistema Operativo:</label>
                        <select class="sistema" name="sistema[]">
                            <option value="Sin-definir">Sin Definir</option>
                            <option value="Ubuntu Server">Ubuntu 22.04.5 LTS Server</option>
                            <option value="Ubuntu Desktop">Ubuntu 22.04.5 LTS Desktop</option>
                            <option value="Debian 12.0">Debian 12.0 LTS</option>
                            <option value="Windows Server 2019">Windows Server 2019</option>
                            <option value="Windows Server 2022">Windows Server 2022</option>
                            <option value="Windows Server 2025">Windows Server 2025</option>
                            <option value="Windows 10">Windows 10</option>
                            <option value="Windows 11">Windows 11</option>
                        </select>
                    </div>
                    <div>
                        <label>Memoria RAM (Max 64 GB):</label>
                        <input type="number" class="ram" name="ram[]" value="4" min="1" max="64">
                    </div>
                    <div>
                        <label>Cantidad de CPUs (Max 16 CPUs):</label>
                        <input type="number" class="cpu" name="cpu[]" value="2" min="1" max="16">
                    </div>
                    <div>
                        <label>Espacio en Disco (Max 2000 GB):</label>
                        <input type="number" class="disco" name="disco[]" value="30" min="20" max="2000">
                    </div>
                    <div>
                        <label for="asistenciatecnica">Asistencia Tecnica (+5€):</label>
                        <select class="asistenciatecnica" name="asistenciatecnica[]">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                    <div>
                        <label for="monitorizacion">Monitorización H24 + Alertas Personalizadas (+3€):</label>
                        <select class="monitorizacion" name="monitorizacion[]">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>
                    <div>
                        <h3>Total: €<span class="preciomaquina"></span></h3>
                    </div>
                </div>
            </div>

            <div class="formato-precio-total">
                <div><p>Precio Total:</p></div>
                <div><button class="boton-comprar" type="submit">Comprar</button></div>
            </div>
        </form>
    </main>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const precioRAM = 0.5;
    const precioCPU = 1.5;
    const precioDisco = 0.01;
    const precioMonitorizacion = 3;
    const precioAsistenciaTecnica = 5;
    const descuento = 0.10;

    const maquinasInput = document.getElementById("maquinas");
    const contenedorFormularios = document.getElementById("formularios-container");
    const plantilla = contenedorFormularios.querySelector(".plantilla");
    const precioTotalElement = document.querySelector(".formato-precio-total p");
    const precioConDescuentoElement = document.createElement("p");

    function calcularPrecio(formulario) {
        const ram = parseInt(formulario.querySelector(".ram").value);
        const cpu = parseInt(formulario.querySelector(".cpu").value);
        const disco = parseInt(formulario.querySelector(".disco").value);
        const monitorizacion = parseInt(formulario.querySelector(".monitorizacion").value) === 1 ? precioMonitorizacion : 0;
        const asistenciatecnica = parseInt(formulario.querySelector(".asistenciatecnica").value) === 1 ? precioAsistenciaTecnica : 0;

        const precio = (ram * precioRAM) + (cpu * precioCPU) + (disco * precioDisco) + monitorizacion + asistenciatecnica;
        formulario.querySelector(".preciomaquina").textContent = precio.toFixed(2);
        return precio;
    }

    function generarFormularios() {
        contenedorFormularios.querySelectorAll(".menu-compra:not(.plantilla)").forEach(f => f.remove());
        const cantidad = parseInt(maquinasInput.value);

        for (let i = 0; i < cantidad; i++) {
            const nuevo = plantilla.cloneNode(true);
            nuevo.classList.remove("plantilla");
            nuevo.style.display = "block";

            ["input", "select"].forEach(selector => {
                nuevo.querySelectorAll(selector).forEach(input => {
                    input.addEventListener("input", () => {
                        calcularPrecio(nuevo);
                        actualizarPrecioTotal();
                    });
                    input.addEventListener("change", () => {
                        calcularPrecio(nuevo);
                        actualizarPrecioTotal();
                    });
                });
            });

            contenedorFormularios.appendChild(nuevo);
            calcularPrecio(nuevo);
        }

        actualizarPrecioTotal();
    }

    function actualizarPrecioTotal() {
        let total = 0;
        const formularios = contenedorFormularios.querySelectorAll(".menu-compra:not(.plantilla)");
        formularios.forEach(f => {
            const precio = parseFloat(f.querySelector(".preciomaquina").textContent);
            total += precio;
        });

        const conDescuento = total * (1 - descuento);
        precioTotalElement.innerHTML = `Precio Original: €${total.toFixed(2)}`;
        precioConDescuentoElement.innerHTML = `Precio con Descuento: €${conDescuento.toFixed(2)}`;

        const contenedorPrecio = document.querySelector(".formato-precio-total");
        if (!contenedorPrecio.contains(precioConDescuentoElement)) {
            contenedorPrecio.appendChild(precioConDescuentoElement);
        }
    }

    maquinasInput.addEventListener("input", generarFormularios);
    generarFormularios();
});
</script>

    <div id="resumen"></div>

    <footer>
        <p>Copyright © 2025 Xhosting. Todos los derechos reservados.</p>
        <a href="#top"><img src="img/top.jpg" alt=""></a>
    </footer>
</body>


</html>