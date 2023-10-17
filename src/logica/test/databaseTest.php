<?php
use PHPUnit\Framework\TestCase;

require_once('Database.php'); // Importa la clase Database

class DatabaseTest extends TestCase
{
    public function testConnection()
    {
        // Crea una instancia de la clase Database
        $db = new Database();

        // Obtiene la conexión activa a la base de datos
        $connection = $db->getConnection();

        // Asegúrate de que la conexión sea una instancia de mysqli
        $this->assertInstanceOf(mysqli::class, $connection);

        // Cierra la conexión
        $db->closeConnection();
    }
}
