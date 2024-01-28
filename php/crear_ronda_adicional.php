<?php
require_once 'conexion.php';
session_start();

    // Obtener el ID del usuario que inició sesión
    $usuarioId = $_SESSION['usuario_id'];

    // Obtener los IDs de los alumnos creados por el usuario
    $obtenerAlumnosCreadosQuery = "SELECT alumno_id FROM alumnos WHERE usuario_id = $usuarioId LIMIT 4";
    $resultadoAlumnosCreados = $conexion->query($obtenerAlumnosCreadosQuery);
    $alumnosCreadosIds = [];
    while ($fila = $resultadoAlumnosCreados->fetch_assoc()) {
        $alumnosCreadosIds[] = $fila['alumno_id'];
    }

    // Asegurarse de que hay al menos 4 alumnos creados por el usuario
    if (count($alumnosCreadosIds) >= 4) {
        $alumno1Id = $alumnosCreadosIds[0];
        $alumno2Id = $alumnosCreadosIds[1];
        $alumno3Id = $alumnosCreadosIds[2];
        $alumno4Id = $alumnosCreadosIds[3];

        // Obtener el ID del último torneo
        $usuarioTorneoId = $_SESSION['usuario_torneo_id'];

        // Crear una nueva ronda para el torneo (2da ronda)
        $insertRondaQuery = "INSERT INTO rondas (torneo_id, numero, estado) VALUES ($usuarioTorneoId, 2, 'pendiente')";
        if ($conexion->query($insertRondaQuery) === false) {
            echo "Error al crear la ronda: " . $conexion->error;
        } else {
            // Obtener el ID de la ronda insertada
            $rondaId = $conexion->insert_id;

            // Crear el enfrentamiento entre los alumnos 3 y 4 para la segunda ronda
            $insertEnfrentamientoQuery = "INSERT INTO enfrentamientos (ronda_id, num_enfrentamiento, alumno1_id, alumno2_id, usuario_id)
                                        VALUES ($rondaId, 1, $alumno3Id, $alumno4Id, $usuarioId)";
            if ($conexion->query($insertEnfrentamientoQuery) === false) {
                echo "Error al crear el enfrentamiento: " . $conexion->error;
            } else {
                // Redirigir a la página de resultados con el valor de ronda_id
                header("Location: ../resultado_ronda_adicional.php?ronda_id=$rondaId");
                exit();
            }
        }
    } else {
        echo "No hay suficientes alumnos creados por el usuario para crear el enfrentamiento.";
    }

    // Cerrar la conexión
    mysqli_close($conexion);

?>