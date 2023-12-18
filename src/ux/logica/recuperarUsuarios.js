const medicionesTable = document.getElementById('usuariosTable');
const stopUpdateButton = document.getElementById('stopUpdate');

// Verifica si los elementos HTML existen
if (!medicionesTable) {
    console.error("Elemento 'usuariosTable' no encontrado.");
} else if (!stopUpdateButton) {
    console.error("Elemento 'stopUpdate' no encontrado.");
} else {
    let updating = true;

    function obtenerMediciones(cb) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    console.log("Recibo: " + this.responseText);
                    var medicionesData = JSON.parse(this.responseText);
                    console.log("Parse result: " + medicionesData);
                    cb(medicionesData);
                } catch (error) {
                    console.error("Error al analizar JSON:", error);
                }
            }
        };

        xmlhttp.open("GET", "../rest/user/nodes", true);
        xmlhttp.send();
    }

    function updateTable() {
        obtenerMediciones(function (mediciones) {
            var tableBody = document.getElementById('usuariosTable');
            tableBody.innerHTML = ''; // Limpiamos el contenido actual de la tabla
    
            // Iteramos sobre las mediciones y agregamos filas a la tabla
            mediciones.forEach((medicion) => {
                var newRow = tableBody.insertRow();
                newRow.innerHTML = `<td>${medicion.email}</td>
                                   <td>${medicion.ultimaFechaEnvio}</td>
                                   <td>${medicion.nombreApellidos}</td>`;

            });
        });
    }

    function startAutoUpdate() {
        setInterval(function () {
            if (updating) {
                updateTable();
            }
        }, 5000); // Actualiza cada 5 segundos, ajusta según sea necesario
    }

    // Inicia la actualización automática al cargar la página
    startAutoUpdate();

    stopUpdateButton.addEventListener('click', () => {
        updating = !updating;
    });
}