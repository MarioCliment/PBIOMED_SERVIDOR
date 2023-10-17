document.getElementById('logoutButton').addEventListener('click', function() {
    // Realizar una solicitud al archivo de cierre de sesión (hacerLogout.php)
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Redirigir al usuario después de cerrar sesión
            window.location.href = 'Aplicacion.html';
        }
    };
    xmlhttp.open('GET', '../rest/hacerLogout.php', true);
    xmlhttp.send();
});
