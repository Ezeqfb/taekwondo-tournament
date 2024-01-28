<?php
    class EscuelaAlumno extends Orm{

        public function __construct(PDO $conexion){
            parent::__construct('id', 'escuela_alumno', $conexion);
        }
    }
?>