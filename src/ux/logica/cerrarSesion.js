document.getElementById('logoutButton').addEventListener('click', function() {
    // Realizar una solicitud al archivo de cierre de sesión (hacerLogout.php)
    var xmlhttp = new XMLHttpRequest();
    alert("Sesión cerrada");
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Redirigir al usuario después de cerrar sesión
            window.location.href = '../ux/index.html';
        }
    };
    xmlhttp.open('DELETE', '../rest/user/logout', true);
    xmlhttp.send();
});
