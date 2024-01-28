<?php
require_once 'conexion.php';
session_start();

if (isset($_SESSION['usuario_id'])) {
    // Obtener el ID del usuario que inició sesión
    $usuarioId = $_SESSION['usuario_id'];

    // Obtener el ID del torneo del usuario
    $obtenerTorneoIdQuery = "SELECT torneo_id FROM torneo WHERE usuario_id = $usuarioId";
    $resultadoTorneoId = $conexion->query($obtenerTorneoIdQuery);

    if ($resultadoTorneoId && $resultadoTorneoId->num_rows > 0) {
        $filaTorneoId = $resultadoTorneoId->fetch_assoc();
        $torneoId = $filaTorneoId['torneo_id'];

        // Verificar si hay al menos dos rondas anteriores finalizadas en el torneo
        $verificarRondasQuery = "SELECT COUNT(*) as total FROM rondas WHERE torneo_id = $torneoId AND estado = 'finalizada'";
        $resultadoVerificacion = $conexion->query($verificarRondasQuery);
        $rondasFinalizadas = $resultadoVerificacion->fetch_assoc()['total'];

        if ($rondasFinalizadas >= 2) {
            // Obtener los IDs de los ganadores de las rondas anteriores
            $obtenerGanadoresQuery = "SELECT DISTINCT ganador_id FROM enfrentamientos WHERE ronda_id IN 
                                      (SELECT ronda_id FROM rondas WHERE torneo_id = $torneoId AND estado = 'finalizada')
                                      AND usuario_id = $usuarioId";
            $resultadoGanadores = $conexion->query($obtenerGanadoresQuery);

            if ($resultadoGanadores && $resultadoGanadores->num_rows >= 2) {
                $filaGanador1 = $resultadoGanadores->fetch_assoc();
                $filaGanador2 = $resultadoGanadores->fetch_assoc();

                $ganador1Id = $filaGanador1['ganador_id'];
                $ganador2Id = $filaGanador2['ganador_id'];

                // Crear una nueva ronda para el torneo (ronda final)
                $insertRondaFinalQuery = "INSERT INTO rondas (torneo_id, numero, estado) VALUES ($torneoId, 3, 'pendiente')";
                if ($conexion->query($insertRondaFinalQuery) === false) {
                    echo "Error al crear la ronda final: " . $conexion->error;
                } else {
                    $rondaFinalId = $conexion->insert_id; // Obtener el ID de la ronda final insertada

                    // Crear el enfrentamiento para la ronda final
                    $insertEnfrentamientoFinalQuery = "INSERT INTO enfrentamientos (ronda_id, num_enfrentamiento, alumno1_id, alumno2_id, usuario_id)
                                                       VALUES ($rondaFinalId, 2, $ganador1Id, $ganador2Id, $usuarioId)";
                    if ($conexion->query($insertEnfrentamientoFinalQuery) === false) {
                        echo "Error al crear el enfrentamiento final: " . $conexion->error;
                    } else {
                        // Actualizar los lugares en la tabla 'torneo'
                        $actualizarLugaresQuery = "UPDATE torneo SET primer_lugar = $ganador1Id, segundo_lugar = $ganador2Id, estado = 'finalizado' WHERE torneo_id = $torneoId";
                        if ($conexion->query($actualizarLugaresQuery) === false) {
                            echo "Error al actualizar los lugares del torneo: " . $conexion->error;
                        } else {
                            // Redirigir a la página de resultados con el valor de ronda_id
                            header("Location: ../resultado_rfinal.php?ronda_id=$rondaFinalId");
                            exit();
                        }
                    }
                }
            } else {
                echo "No hay suficientes ganadores definidos para crear la ronda final.";
            }
        } else {
            echo "No hay suficientes rondas anteriores finalizadas para crear la ronda final.";
        }
    } else {
        echo "No se encontró el ID del torneo para el usuario actual.";
    }
} else {
    echo "Usuario no identificado.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>