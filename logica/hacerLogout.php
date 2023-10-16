<?php
function hacerLogout()  {

    session_start(); // Inicia la sesión

    // Destruye la sesión, lo que equivale a cerrar la sesión
    session_destroy();


    // Redirige al usuario a la página de inicio de sesión u otra página de tu elección
    header("Location: ../ux/Aplicacion.html");
    //exit;
};

?>
