<?php
    include 'header.php';
?>
    <body class="body-adquirir-tarifa">
    <main class="main-adquirir">
        <h2>Tarifa Asistencia</h2>
        <form id="configurador" method="post" action="escribirasistencia.php">
            <div class="cantidad-maquinas">
                <label for="maquinas">Número de Máquinas Virtuales:</label>
                <input type="number" id="maquinas" name="maquinas" value="1" min="1" max="4">
            </div>    

            <input type="hidden" name="cantidad_maquinas" id="cantidad-maquinas-enviada">   

            <div class="formularios-container-class" id="formularios-container">
                <div class="menu-compra" id="menu-compra-template" style="display:none;">
                    <div>
                        <label for="nombre_maquina">Nombre de la Máquina:</label>
                        <input type="text" class="nombre_maquina" name="nombre_maquina[]" value="Maquina" required>
                    </div>
                    <div>
                        <label for="sistema">Sistema Operativo:</label>
                        <select class="sistema" name="sistema[]">
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
                        <label for="asistenciatecnica">Asistencia Tecnica (+0€):</label>
                        <select class="asistenciatecnica" name="asistenciatecnica[]">
                            <option value="1">Si</option>
                        </select>
                    </div>
                    <div>
                        <label for="monitorizacion">Monitorización H24 + Alertas Personalizadas (+3€):</label>
                        <select class="monitorizacion" name="monitorizacion[]">
                            <option value="0">No</option>
                            <option value="1">Si</option>
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

        <script>
document.addEventListener("DOMContentLoaded", function () {
    const precioRAM = 0.5;
    const precioCPU = 1.5;
    const precioDisco = 0.01;
    const precioMonitorizacion = 3; // Precio por la monitorización H24
    const precioAsistenciaTecnica = 4; // Nuevo precio para asistencia técnica

    const maquinasInput = document.getElementById("maquinas");
    const contenedorFormularios = document.getElementById("formularios-container");
    const formularioBase = document.getElementById("menu-compra-template");
    const precioTotalElement = document.querySelector(".formato-precio-total p"); // Referencia al elemento donde mostrar el total

    // Función para calcular el precio de una máquina virtual y actualizar el span "preciomaquina"
    function calcularPrecio(formulario) {
        const ram = parseInt(formulario.querySelector(".ram").value);
        const cpu = parseInt(formulario.querySelector(".cpu").value);
        const disco = parseInt(formulario.querySelector(".disco").value);
        const monitorizacion = parseInt(formulario.querySelector(".monitorizacion").value) === 1 ? precioMonitorizacion : 0;
        const asistenciatecnica = parseInt(formulario.querySelector(".asistenciatecnica").value) === 1 ? precioAsistenciaTecnica : 0;

        const preciomaquina = (ram * precioRAM) + (cpu * precioCPU) + (disco * precioDisco) + monitorizacion + asistenciatecnica;
        formulario.querySelector(".preciomaquina").textContent = preciomaquina.toFixed(2);
        return preciomaquina;
    }

    // Función para generar los formularios dinámicamente según la cantidad
    function generarFormularios() {
        contenedorFormularios.innerHTML = ""; // Limpiar formularios anteriores
        const cantidad = parseInt(maquinasInput.value);
        console.log("Cantidad de máquinas seleccionada:", cantidad);
        document.getElementById("cantidad-maquinas-enviada").value = cantidad;
        let precioTotal = 0;

        for (let i = 0; i < cantidad; i++) {
            const nuevoFormulario = formularioBase.cloneNode(true);
            nuevoFormulario.removeAttribute("id"); // Quitar el ID duplicado
            nuevoFormulario.style.display = "block"; // Hacerlo visible
            contenedorFormularios.appendChild(nuevoFormulario);
            console.log("Formulario generado:", nuevoFormulario);

            // Añadir eventos para actualizar precio dinámicamente
            ["ram", "cpu", "disco", "monitorizacion", "asistenciatecnica"].forEach(clase => {
                const input = nuevoFormulario.querySelector(`.${clase}`);
                if (input) {
                    input.addEventListener("input", () => {
                        calcularPrecio(nuevoFormulario);
                        actualizarPrecioTotal();
                    });
                    input.addEventListener("change", () => {
                        calcularPrecio(nuevoFormulario);
                        actualizarPrecioTotal();
                    });
                }
            });

            // Calcular precio inicial
            precioTotal += calcularPrecio(nuevoFormulario);
        }

        // Actualizar el precio total cuando los formularios se generen
        actualizarPrecioTotal();
    }

    // Función para actualizar el precio total en el HTML
    function actualizarPrecioTotal() {
        let precioTotal = 0;
        const formularios = contenedorFormularios.querySelectorAll(".menu-compra");
        formularios.forEach(formulario => {
            const precioMaquina = parseFloat(formulario.querySelector(".preciomaquina").textContent);
            precioTotal += precioMaquina;
        });

        // Actualizar el precio total en el elemento .formato-precio-total p
        precioTotalElement.innerHTML = `Precio Total: €${precioTotal.toFixed(2)}`;
    }

    // Detectar cambios en la cantidad de máquinas y generar formularios
    maquinasInput.addEventListener("input", generarFormularios);

    // Generar los formularios al inicio
    generarFormularios();
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