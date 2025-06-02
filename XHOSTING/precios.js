<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Definir los precios por unidad
        const precioRAM = 5; // $5 por GB
        const precioCPU = 10; // $10 por núcleo
        const precioDisco = 0.5; // $0.5 por GB

        // Elementos del formulario
        const ramInput = document.getElementById("ram");
        const cpuInput = document.getElementById("cpu");
        const discoInput = document.getElementById("disco");
        const precioTotalSpan = document.getElementById("precioTotal");

        // Función para calcular el precio
        function calcularPrecio() {
            const ram = parseInt(ramInput.value);
            const cpu = parseInt(cpuInput.value);
            const disco = parseInt(discoInput.value);

            // Cálculo del precio
            const precioTotal = (ram * precioRAM) + (cpu * precioCPU) + (disco * precioDisco);

            // Mostrar el precio
            precioTotalSpan.textContent = precioTotal.toFixed(2);
        }

        // Eventos para actualizar el precio cuando cambian los valores
        ramInput.addEventListener("input", calcularPrecio);
        cpuInput.addEventListener("input", calcularPrecio);
        discoInput.addEventListener("input", calcularPrecio);

        // Calcular el precio inicial
        calcularPrecio();
    });
</script>