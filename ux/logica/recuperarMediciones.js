const medicionesTable = document.getElementById('medicionesTable');
const stopUpdateButton = document.getElementById('stopUpdate');

// Verifica si los elementos HTML existen
if (!medicionesTable) {
    console.error("Elemento 'medicionesTable' no encontrado.");
} else if (!stopUpdateButton) {
    console.error("Elemento 'stopUpdate' no encontrado.");
} else {
    let updating = true;

    function updateMediciones() {
        if (updating) {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        console.log("Respuesta JSON:", this.responseText);
                        try {
                            const medicionesData = JSON.parse(this.responseText);
                            medicionesTable.innerHTML = '';
                            medicionesData.forEach((medicion) => {
                                medicionesTable.innerHTML += `<tr>
                                    <td>${medicion.id_medicion}</td>
                                    <td>${medicion.tiempo}</td>
                                    <td>${medicion.temperatura}</td>
                                    <td>${medicion.concentracion}</td>
                                </tr>`;
                            });
                        } catch (error) {
                            console.error("Error al analizar JSON:", error);
                        }
                    } else {
                        console.error("Error de solicitud:", this.status, this.statusText);
                    }
                    setTimeout(updateMediciones, 1000);
                }
            };
            xmlhttp.open("GET", "../rest/recuperarMediciones.php", true);
            xmlhttp.send();
        }
    }

    updateMediciones();

    stopUpdateButton.addEventListener('click', () => {
        updating = !updating;
    });
}