<?php
    include 'header.php';
?>
    <body class="body-adquirir-tarifa">
    <main class="main-adquirir">
        <h2>Tarifa Básico</h2>
        <form action="escribirbasico.php" method="post" id="configurador">
            <div class="cantidad-maquinas">
                <label for="maquinas">Número de Máquinas Virtuales:</label>
                <input type="number" id="maquinas" name="maquinas" value="1" min="1" max="4">
            </div>       

            <div id="formularios-container" class="formularios-container-class"></div>

            <input type="hidden" name="cantidad_maquinas" id="cantidad_maquinas" value="1">

            <div class="formato-precio-total">
                <p>Precio Total: €<span id="precio-total">0.00</span></p>
                <button class="boton-comprar" type="submit">Comprar</button>
            </div>
        </form>
    </main>

    <template id="formulario-maquina-template">
        <div class="menu-compra">
            <div>
                <label>Nombre de la Máquina:</label>
                <input type="text" name="nombre_maquina[]" value="Máquina" required>
            </div>
            <div>
                <label>Sistema Operativo:</label>
                <select name="sistema[]">
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
                <input type="number" name="ram[]" value="4" min="1" max="64">
            </div>
            <div>
                <label>Cantidad de CPUs (Max 16 CPUs):</label>
                <input type="number" name="cpu[]" value="2" min="1" max="16">
            </div>
            <div>
                <label>Espacio en Disco (Max 2000 GB):</label>
                <input type="number" name="disco[]" value="30" min="20" max="2000">
            </div>
            <div>
                <label>Monitorización H24 + Alertas Personalizadas (+3€):</label>
                <select name="monitorizacion[]">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
            <div>
                <h3>Total: €<span class="preciomaquina">0.00</span></h3>
            </div>
        </div>
    </template>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const precioRAM = 0.5;
        const precioCPU = 1.5;
        const precioDisco = 0.01;
        const precioMonitorizacion = 3;

        const maquinasInput = document.getElementById("maquinas");
        const contenedorFormularios = document.getElementById("formularios-container");
        const plantillaFormulario = document.getElementById("formulario-maquina-template");
        const totalGlobal = document.getElementById("precio-total");
        const cantidadInputHidden = document.getElementById("cantidad_maquinas");

        function calcularPrecio(formulario) {
            const ram = parseFloat(formulario.querySelector("[name='ram[]']").value) || 0;
            const cpu = parseFloat(formulario.querySelector("[name='cpu[]']").value) || 0;
            const disco = parseFloat(formulario.querySelector("[name='disco[]']").value) || 0;
            const monitorizacion = formulario.querySelector("[name='monitorizacion[]']").value === "1" ? precioMonitorizacion : 0;
            const precio = (ram * precioRAM) + (cpu * precioCPU) + (disco * precioDisco) + monitorizacion;
            formulario.querySelector(".preciomaquina").textContent = precio.toFixed(2);
            return precio;
        }

        function actualizarTotal() {
            let total = 0;
            const formularios = contenedorFormularios.querySelectorAll(".menu-compra");
            formularios.forEach(f => {
                total += calcularPrecio(f);
            });
            totalGlobal.textContent = total.toFixed(2);
        }

        function generarFormularios() {
            contenedorFormularios.innerHTML = "";
            const cantidad = parseInt(maquinasInput.value) || 1;
            cantidadInputHidden.value = cantidad;

            for (let i = 0; i < cantidad; i++) {
                const clon = plantillaFormulario.content.cloneNode(true);
                contenedorFormularios.appendChild(clon);
            }

            contenedorFormularios.querySelectorAll(".menu-compra").forEach(f => {
                ["ram[]", "cpu[]", "disco[]", "monitorizacion[]"].forEach(name => {
                    f.querySelector(`[name='${name}']`).addEventListener("input", actualizarTotal);
                });
                calcularPrecio(f);
            });

            actualizarTotal();
        }

        maquinasInput.addEventListener("input", generarFormularios);
        generarFormularios();
    });
    </script>

    <footer>
        <p>&copy; 2025 Xhosting. Todos los derechos reservados.</p>
        <a href="#top"><img src="img/top.jpg" alt="Subir al inicio"></a>
    </footer>
</body>
</html>