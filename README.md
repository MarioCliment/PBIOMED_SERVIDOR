# PBIOMED_SERVIDOR

## Descripción del Proyecto

Este forma parte del proyecto 3A (Biometria y Medio Ambiente), en concreto podemos encontrar la parte correspondiente al Servidor y la Pagina Web

## Estructura del Proyecto

El proyecto se encuentra dividido en varias carpetas para organizar de manera efectiva el código y los recursos. A continuación, se detalla la estructura del proyecto:

- **docs**: La carpeta "docs" es el lugar donde puedes almacenar la documentación relacionada con tu proyecto. Puedes incluir documentos como guías de usuario, manuales técnicos o cualquier otro tipo de documentación.

- **src**: La carpeta "src" contiene todos las carpetas del servidor para su correcto funcionamiento y se explica su contenido a continuación.

- **ux**: La carpeta "ux" alberga los archivos JavaScript (Contenidos en la carpeta "logica") y recursos relacionados con la interfaz de usuario (Aplicacion.html y Mediciones.html). Aquí se encuentran los archivos JavaScript utilizados para la lógica del cliente, así como otros recursos relacionados con la interfaz de usuario.

- **logica**: La carpeta "logica" contiene la lógica principal de tu aplicación. Aquí se manejan las operaciones principales, como el inicio de sesión, el cierre de sesión, el acceso a la base de datos y otras funciones esenciales. También es donde se encuentran los archivos de prueba para las pruebas de lógica.

- **rest**: La carpeta "rest" alberga la API REST de tu proyecto. Aquí se definen los servicios web que permiten la comunicación entre tu aplicación y otros sistemas. También es el lugar donde puedes realizar pruebas unitarias de tus servicios REST.

- **bbdd**: La carpeta "bbdd" se utiliza para almacenar archivos relacionados con la base de datos. Esto puede incluir archivos de respaldo o scripts SQL para configurar la base de datos.



## Requisitos Previos

Asegúrate de tener lo siguiente instalado en tu sistema antes de desplegar y ejecutar las pruebas para este proyecto:

- **XAMPP**: Asegúrate de tener XAMPP instalado en tu sistema. Puedes descargarlo desde [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html) y seguir las instrucciones de instalación.

- **PHPUnit**: Asegúrate de haber descargado el archivo `phpunit.phar` y reemplazado el archivo existente en la carpeta `C:\xampp\php`. Puedes obtener PHPUnit desde [https://phpunit.de/](https://phpunit.de/).

## Cómo Desplegar el Proyecto

Sigue estos pasos para desplegar el proyecto en tu entorno de desarrollo:

1. **Clona el Repositorio**: Clona este repositorio en tu máquina local.

2. **Ubica el Proyecto en htdocs**: Copia la carpeta de tu proyecto en la carpeta "htdocs" dentro de la instalación de XAMPP. Por lo general, la ruta es `C:\xampp\htdocs` en sistemas Windows.

3. **Añadir la Carpeta de PHP al PATH**: Para poder ejecutar comandos de PHP desde cualquier ubicación en la línea de comandos, debes agregar la carpeta donde se encuentra PHP (por lo general, `C:\xampp\php`) a las variables de entorno del sistema. Puedes seguir las instrucciones detalladas a continuación:

   - Abre el Panel de Control en tu sistema Windows.
   - Selecciona "Sistema y Seguridad" en el Panel de Control.
   - Elige "Sistema" dentro de "Sistema y Seguridad".
   - Haz clic en "Configuración avanzada del sistema."
   - En la ventana "Propiedades del sistema," ve a la pestaña "Avanzado."
   - En la sección "Variables de Entorno," haz clic en el botón "Variables de Entorno..."
   - En la sección "Variables del sistema," selecciona la variable "Path" (o "PATH") y haz clic en "Editar..."
   - En la ventana "Editar variable de sistema," agrega la ruta completa de la carpeta PHP (por lo general, `C:\xampp\php`) y luego haz clic en "Aceptar."

4. **Reinicia la Línea de Comandos o Terminal**: Es importante reiniciar la línea de comandos o la terminal para que los cambios surtan efecto. Puedes cerrar y volver a abrir la línea de comandos o reiniciar tu ordenador.

5. **Descarga e Importa la Base de Datos**: Debes descargar la base de datos que se encuentra en el proyecto y luego importarla en phpMyAdmin. Sigue estos pasos:

   - Descarga la base de datos proporcionada en el proyecto (generalmente un archivo .sql).
   - Abre phpMyAdmin desde tu navegador web (por lo general, [http://localhost/phpmyadmin](http://localhost/phpmyadmin)).
   - Crea una nueva base de datos con el mismo nombre que se especifica en el archivo de la base de datos.
   - Selecciona la base de datos recién creada y ve a la pestaña "Importar".
   - Haz clic en "Seleccionar archivo" y elige el archivo .sql que descargaste.
   - Haz clic en "Continuar" para importar la base de datos.

## Cómo Acceder a las Páginas Principales

- **Página Principal ("Aplicacion")**: Para acceder a la página principal de tu proyecto, abre un navegador web e ingresa la URL correspondiente. Por lo general, será [http://localhost/nombre_de_tu_proyecto/Index](http://localhost/nombre_de_tu_proyecto/Index).

- **Página de Mediciones ("Mediciones")**: La página de mediciones está diseñada para que los usuarios registrados puedan ver sus mediciones y otra información relevante. Accede a esta página a través de la URL, pero para poder ver las mediciones deberás haber iniciado sesión previamente [http://localhost/nombre_de_tu_proyecto/Mediciones](http://localhost/nombre_de_tu_proyecto/Mediciones).

## Autor

- [@MarioCliment](https://www.github.com/MarioCliment)
