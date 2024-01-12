<?php 
if(isset($_GET['email'] )){
    $email = $_GET['email'];
   
}

//CAMBIAR IP PARA USOS
$ipserver = "192.168.1.148:80"; //CASA GRASA
//192.168.10.7 MOVIL MARIO
// 192.168.1.140

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifiar Cuenta</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-md-center" style="margin-top:15%">
            <form class="col-3" id="verificationForm">
                <h2>Verificar Cuenta</h2>
                <div class="mb-3">
                    <label for="c" class="form-label">Código de Verificación</label>
                    <input type="number" class="form-control" id="c" name="codigo">
                    <input type="hidden" class="form-control" id="email" name="email" value="<?php echo $email;?>">
                </div>
               
                <button type="submit" class="btn btn-primary" onclick="verificarCuenta()">Verificar</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
<script>
    function verificarCuenta() {
        // Obtener los valores del formulario
        var codigo = document.getElementById('c').value;
        var email = document.getElementById('email').value;

        // Construir el objeto JSON
        var data = {
            codigo: codigo,
            email: email
        };

        // Configurar la solicitud AJAX con fetch 
        fetch(/*'http://192.168.10.7:80/PBIOMED_SERVIDOR/src/rest/user/verify'*/'http://192.168.1.140:80/PBIOMED_SERVIDOR/src/rest/user/verify', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            // Manejar la respuesta del servidor
            console.log(response);
            // Puedes agregar más lógica aquí según la respuesta del servidor
        })
        .catch(error => {
            // Manejar errores
            console.error('Error:', error);
        });

        // Evitar que el formulario se envíe como GET
        return false;
    }
</script>
</html>