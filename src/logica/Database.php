<?php
class Database {
    private $conn = null;

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
        $servername = DB_HOST;
        $usernameROOT = DB_USERNAME;
        $passwordROOT = DB_PASSWORD;
        $dbname = DB_NAME;

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

    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function selectFetch($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_object();				
            $stmt->close();
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function insert($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );		
            $stmt->close();
            return true;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function update($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );		
            $stmt->close();
            return true;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
    
    
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->conn->prepare( $query );
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }
            $stmt->execute();
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }
}
?>
