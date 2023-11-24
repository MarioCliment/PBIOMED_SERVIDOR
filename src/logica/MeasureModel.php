<?php
require_once "Database.php";
class MeasureModel extends Database
{
    private $objetoResultado;

    public function addMeasure($idTipoMedicion, $fecha, $lugar, $valor){
        return $this->insert("INSERT INTO mediciones (idTipoMedicion, fecha, lugar, valor) VALUES ('$idTipoMedicion', '$fecha', '$lugar', '$valor')");
    }

    public function getLastMeasure()
    {
        return $this->select("SELECT * FROM mediciones ORDER BY idMedicion DESC LIMIT 1");
    }

    public function getAllMeasures($limit)
    {
        return $this->select("SELECT * FROM mediciones ORDER BY idMedicion DESC LIMIT ?", ["i", $limit]);
    }
}