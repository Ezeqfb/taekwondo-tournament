<?php
require_once(__DIR__ . '/Orm.php');

class Alumno extends Orm
{
    public function __construct(PDO $conexion)
    {
        parent::__construct('alumno_id', 'alumnos', $conexion);
    }

    public function insertAlumno($nombre, $edad, $puntos, $usuarioId)
    {
        $sql = "INSERT INTO alumnos (nombre, edad, puntos, usuario_id) VALUES (?, ?, ?, ?)";
        $stm = $this->db->prepare($sql);
        $stm->execute([$nombre, $edad, $puntos, $usuarioId]);
        return $this->db->lastInsertId();
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
?>