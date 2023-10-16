<?php
class Database {
    private $conn;

    // -------------------------------------------------
    //
    // Constructor de la clase Database.
    //
    // Parámetros:
    // - Ninguno.
    //
    // Acción:
    // Crea una conexión a la base de datos utilizando las credenciales proporcionadas.
    //
    // -------------------------------------------------
    public function __construct() {
        $servername = "localhost";
        $username = "admin";
        $usernameROOT = "root";
        $password = "1234";
        $passwordROOT = "";
        $dbname = "PBIOMED";

        //$this->conn = new mysqli($servername, $username, $password, $dbname);

        $this->conn = new mysqli($servername, $usernameROOT, $passwordROOT, $dbname);

        //$this->conn = new mysqli($servername, $dbname);

        if ($this->conn->connect_error) {
            die("La conexión a la base de datos falló: " . $this->conn->connect_error);
        }
    }

    // -------------------------------------------------
    //
    // Obtiene la conexión activa a la base de datos.
    //
    // Parámetros:
    // - Ninguno.
    //
    // Devuelve:
    // - mysqli: La conexión activa a la base de datos.
    //
    // -------------------------------------------------
    public function getConnection() {
        return $this->conn;
    }

    // -------------------------------------------------
    //
    // Cierra la conexión a la base de datos.
    //
    // Parámetros:
    // - Ninguno.
    //
    // -------------------------------------------------
    public function closeConnection() {
        $this->conn->close();
    }
}
?>
