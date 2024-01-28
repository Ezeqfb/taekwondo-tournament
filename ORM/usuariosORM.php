<?php
class Usuario extends Orm {
    
    public function __construct(PDO $conexion) {
        parent::__construct('usuario_id', 'usuarios', $conexion);
        $this->conexion = $conexion;
    }

    public function usuarioExists($usuario) {
        $query = "SELECT COUNT(*) as count FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }
}