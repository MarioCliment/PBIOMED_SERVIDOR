// ---------------------------------------------------
// user:Texto, password:Texto -> hacerLogin() -> Boolean
// ---------------------------------------------------
function hacerLogin( user, password, cb ) {

	// preparar la llamada remota
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// callback para cuando llegue la respuesta
		// de la petición que haremos más abajo

		if( this.readyState == 4 && this.status == 200 ){
			// este es el texto JSON recibido la llamada al
			// endpoint, pasado a objeto JSON 
			console.log( "recibo: " + this.responseText )
			var resultado = JSON.parse(this.responseText);
			if (resultado.resultado === true){
				window.location.href = '../ux/Mediciones.html'
			}

			cb( resultado ) // devuelvo el resultado
		}
	};
	
	// llamamos *remotamente* al fichero hacerLogin.php
	// (la verdadera función de la lógica)
	xmlhttp.open("GET", "../rest/user/login?nickname="+user+"&contrasenya="+password, true);
	xmlhttp.send();

} // ()