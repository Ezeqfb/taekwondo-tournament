<?php
require_once 'conexion.php';
session_start();

// Verificar si el usuario está identificado
if (isset($_SESSION['usuario_id'])) {
    // Obtener el ID del usuario que inició sesión
    $usuarioId = $_SESSION['usuario_id'];

    // Obtener el ID del torneo del usuario
    $obtenerTorneoIdQuery = "SELECT torneo_id FROM torneo WHERE usuario_id = $usuarioId";
    $resultadoTorneoId = $conexion->query($obtenerTorneoIdQuery);

    if ($resultadoTorneoId && $resultadoTorneoId->num_rows > 0) {
        $filaTorneoId = $resultadoTorneoId->fetch_assoc();
        $usuarioTorneoId = $filaTorneoId['torneo_id'];

        // Consultar los datos del torneo desde la base de datos
        $obtenerTorneoQuery = "SELECT nombre, fecha, estado FROM torneo WHERE torneo_id = $usuarioTorneoId AND usuario_id = $usuarioId";
        $resultadoTorneo = $conexion->query($obtenerTorneoQuery);

        if ($resultadoTorneo->num_rows > 0) {
            $filaTorneo = $resultadoTorneo->fetch_assoc();
            $nombreTorneo = $filaTorneo['nombre'];
            $fechaTorneo = $filaTorneo['fecha'];
            $estadoTorneo = $filaTorneo['estado'];

            // Insertar datos del torneo en la tabla resultados_torneo
            $insertTorneoQuery = "INSERT INTO resultados_torneo (torneo_id, usuario_id, nombre, fecha, estado)
                                  VALUES ($usuarioTorneoId, $usuarioId, '$nombreTorneo', '$fechaTorneo', '$estadoTorneo')";
            if ($conexion->query($insertTorneoQuery) === true) {
                $resultadoId = $conexion->insert_id;

                // Obtener los IDs de los alumnos creados por el usuario
                $obtenerAlumnosCreadosQuery = "SELECT alumno_id, nombre, edad, puntos FROM alumnos WHERE usuario_id = $usuarioId LIMIT 4";
                $resultadoAlumnosCreados = $conexion->query($obtenerAlumnosCreadosQuery);

                // Asegurarse de que hay al menos 4 alumnos creados por el usuario
                if ($resultadoAlumnosCreados->num_rows >= 4) {
                    // Insertar resultados de los alumnos en la tabla alumnos_resultado
                    while ($fila = $resultadoAlumnosCreados->fetch_assoc()) {
                        $alumnoId = $fila['alumno_id'];
                        $nombreAlumno = $fila['nombre'];
                        $edadAlumno = $fila['edad'];
                        $puntosAlumno = $fila['puntos'];

                        // Insertar los datos en la tabla alumnos_resultado
                        $insertResultadoAlumnoQuery = "INSERT INTO alumnos_resultado (alumno_id, resultado_id, usuario_id, nombre, edad, puntos)
                                                      VALUES ($alumnoId, $resultadoId, $usuarioId, '$nombreAlumno', $edadAlumno, $puntosAlumno)";
                        $conexion->query($insertResultadoAlumnoQuery);
                    }

                    header("Location: ../mostrar_posiciones2.php");
                } else {
                    echo "No hay suficientes alumnos creados por el usuario para crear los resultados.";
                }
            } else {
                echo "Error al guardar los datos del torneo: " . $conexion->error;
            }
        } else {
            echo "No se encontró el torneo correspondiente al usuario.";
        }
    } else {
        echo "No se encontró el ID de torneo del usuario.";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "Usuario no identificado.";
}
?>