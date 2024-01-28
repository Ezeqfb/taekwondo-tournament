<?php
session_start();
require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Orm.php');
require_once(__DIR__ . '/torneoORM.php');

$database = new Database();
$conexion = $database->getConnection();

$torneoModel = new Torneo($conexion);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el ID del usuario que inició sesión
    $usuarioId = $_SESSION['usuario_id'];

    // Obtener datos del formulario
    $nombreTorneo = $_POST['nombreTorneo'];
    $fechaTorneo = $_POST['fechaTorneo'];

    // Insertar un nuevo torneo en la tabla "torneo" utilizando el ORM
    $torneoId = $torneoModel->insertTorneo($nombreTorneo, $fechaTorneo, $usuarioId);
    $_SESSION['usuario_torneo_id'] = $torneoId;

    // Crear una nueva ronda para el torneo (1ra ronda)
    $insertRondaQuery = "INSERT INTO rondas (torneo_id, numero, estado) VALUES ($torneoId, 1, 'pendiente')";
    if ($conexion->query($insertRondaQuery) === false) {
        echo "Error al crear la ronda: " . $conexion->error;
    } else {
        // Obtener el ID de la ronda insertada
        $rondaId = $conexion->lastInsertId();

        // Obtener los IDs de los 4 alumnos creados por el usuario
        $obtenerAlumnosCreadosQuery = "SELECT alumno_id FROM alumnos WHERE usuario_id = $usuarioId LIMIT 4";
        $resultadoAlumnosCreados = $conexion->query($obtenerAlumnosCreadosQuery);
        $alumnosCreadosIds = [];
        while ($fila = $resultadoAlumnosCreados->fetch(PDO::FETCH_ASSOC)) {
            $alumnosCreadosIds[] = $fila['alumno_id'];
        }

        // Asegurarse de que hay al menos 2 alumnos creados por el usuario
        if (count($alumnosCreadosIds) >= 2) {
            $alumno1Id = $alumnosCreadosIds[0];
            $alumno2Id = $alumnosCreadosIds[1];

            // Crear el enfrentamiento para la primera ronda
            $insertEnfrentamientoQuery = "INSERT INTO enfrentamientos (ronda_id, num_enfrentamiento, alumno1_id, alumno2_id, usuario_id)
                                        VALUES ($rondaId, 1, $alumno1Id, $alumno2Id, $usuarioId)";
            if ($conexion->query($insertEnfrentamientoQuery) === false) {
                echo "Error al crear el enfrentamiento: " . $conexion->error;
            } else {
                // Redirigir a la página de resultados con el valor de ronda_id
                header("Location: ../resultados_ronda.php?ronda_id=$rondaId");
                exit();
            }

            echo "Se ha creado el enfrentamiento de la primera ronda.";
        } else {
            echo "No hay suficientes alumnos creados por el usuario para crear el enfrentamiento.";
        }
    }

    // Cerrar la conexión PDO
    $conexion = null;
}
?>
