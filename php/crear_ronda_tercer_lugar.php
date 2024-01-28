<?php
require_once 'conexion.php';
session_start();

if (isset($_GET['ronda_id']) && isset($_SESSION['usuario_id'])) {
    $rondaId = $_GET['ronda_id'];
    $usuarioId = $_SESSION['usuario_id']; // Obtener el ID del usuario de la sesión

    // Función para obtener el ganador de la ronda correspondiente
    function obtenerGanadorTercerLugar($rondaId) {
        global $conexion;
        $obtenerGanadorQuery = "SELECT ganador_id FROM enfrentamientos WHERE ronda_id = $rondaId";
        $resultadoGanador = $conexion->query($obtenerGanadorQuery);
        if ($resultadoGanador && $resultadoGanador->num_rows > 0) {
            $filaGanador = $resultadoGanador->fetch_assoc();
            return $filaGanador['ganador_id'];
        }
        return null;
    }

    // Crear una nueva ronda para el tercer lugar
    $insertRondaTercerLugarQuery = "INSERT INTO rondas (torneo_id, numero, estado) VALUES ($usuarioId, 3, 'pendiente')";
    if ($conexion->query($insertRondaTercerLugarQuery) === false) {
        echo "Error al crear la ronda del tercer lugar: " . $conexion->error;
    } else {
        $rondaTercerLugarId = $conexion->insert_id;

        // Obtener el ganador de la ronda correspondiente
        $ganadorTercerLugarId = obtenerGanadorTercerLugar($rondaId);

        // Insertar el registro en la tabla resultados_torneo si no existe
        $insertarResultadosTorneoQuery = "INSERT IGNORE INTO resultados_torneo (usuario_id) VALUES ($usuarioId)";
        $conexion->query($insertarResultadosTorneoQuery);

        // Actualizar el campo tercer_lugar en la tabla resultados_torneo
        $actualizarTercerLugarQuery = "UPDATE resultados_torneo SET tercer_lugar = $ganadorTercerLugarId WHERE usuario_id = $usuarioId";
        if ($conexion->query($actualizarTercerLugarQuery) === false) {
            echo "Error al actualizar el tercer lugar en la tabla resultados_torneo: " . $conexion->error;
        } else {
            // Redirigir a la página de resultados del tercer lugar
            header("Location: ../resultado_tercer_lugar.php?ronda_id=$rondaTercerLugarId");
            exit();
        }
    }
} else {
    echo "Error: Parámetros incorrectos.";
}
mysqli_close($conexion);
?>