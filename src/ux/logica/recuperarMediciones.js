const medicionesTable = document.getElementById('medicionesTableBody');
const stopUpdateButton = document.getElementById('stopUpdate');

// Verifica si los elementos HTML existen
if (!medicionesTable) {
    console.error("Elemento 'medicionesTable' no encontrado.");
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
                    cb(medicionesData);
                } catch (error) {
                    console.error("Error al analizar JSON:", error);
                }
            }
        };

        xmlhttp.open("GET", "../rest/user/measure/all/data?limit=20", true);
        xmlhttp.send();
    }

    function updateTable() {
        obtenerMediciones(function (mediciones) {
            var tableBody = document.getElementById('medicionesTableBody');
            tableBody.innerHTML = ''; // Limpiamos el contenido actual de la tabla
    
            // Iteramos sobre las mediciones y agregamos filas a la tabla
            mediciones.forEach((medicion) => {
                var newRow = tableBody.insertRow();
                newRow.innerHTML = `<td>${medicion.idMedicion}</td>
                                   <td>${medicion.fecha}</td>
                                   <td>${medicion.lugar}</td>
                                   <td>${medicion.valor}</td>
                                   <td>${medicion.idTipoMedicion}</td>`;
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