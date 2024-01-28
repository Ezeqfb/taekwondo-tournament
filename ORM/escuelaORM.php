<?php
require_once(__DIR__ . '/Orm.php');
class Escuela extends Orm
{
    public function __construct(PDO $conexion)
    {
        parent::__construct('escuela_id', 'escuelas', $conexion);
    }

    public function insertEscuela($nombreEscuela, $usuarioId) {
        $sql = "INSERT INTO escuelas (nombreEscuela, usuario_id) VALUES (?, ?)";
        $stm = $this->db->prepare($sql);
        $stm->execute([$nombreEscuela, $usuarioId]);
        return $this->db->lastInsertId();
    }    
}
?>