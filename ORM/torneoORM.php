<?php

require_once(__DIR__ . '/Orm.php');

class Torneo extends Orm
{
    public function __construct(PDO $conexion)
    {
        parent::__construct('torneo_id', 'torneo', $conexion);
    }

    public function insertTorneo($nombre, $fecha, $usuarioId)
    {
        $sql = "INSERT INTO torneo (nombre, fecha, usuario_id) VALUES (?, ?, ?)";
        $stm = $this->db->prepare($sql);
        $stm->execute([$nombre, $fecha, $usuarioId]);
        return $this->db->lastInsertId();
    }
}

?>
