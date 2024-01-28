<?php
require_once 'php/conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión
    exit();
}

// Obtener el ID del usuario que inició sesión
$usuarioId = $_SESSION['usuario_id'];

// Obtener los alumnos ganadores de la primera ronda
$obtenerGanadoresQuery = "SELECT ganador_id FROM enfrentamientos WHERE ronda_id = 1";
$resultadoGanadores = $conexion->query($obtenerGanadoresQuery);

$ganadores = [];
while ($fila = $resultadoGanadores->fetch_assoc()) {
    $ganadores[] = $fila['ganador_id'];
}

// Verificar si hay suficientes ganadores para crear enfrentamientos en la segunda ronda
if (count($ganadores) >= 2) {
    // Crear una nueva ronda para representar la segunda ronda
    $insertRondaQuery = "INSERT INTO rondas (torneo_id, numero, estado) VALUES (null, 2, 'pendiente')";
    if ($conexion->query($insertRondaQuery) === false) {
        echo "Error al crear la segunda ronda: " . $conexion->error;
    } else {
        $segundaRondaId = $conexion->insert_id;

        // Barajar el array de ganadores para mezclar los enfrentamientos de la segunda ronda
        shuffle($ganadores);

        // Crear los enfrentamientos para la segunda ronda
        $numEnfrentamiento = 1;
        for ($i = 0; $i < count($ganadores); $i += 2) {
            $alumno1Id = $ganadores[$i];
            $alumno2Id = $ganadores[$i + 1];

            $insertEnfrentamientoQuery = "INSERT INTO enfrentamientos (ronda_id, num_enfrentamiento, alumno1_id, alumno2_id)
                                        VALUES ($segundaRondaId, $numEnfrentamiento, $alumno1Id, $alumno2Id)";
            if ($conexion->query($insertEnfrentamientoQuery) === false) {
                echo "Error al crear el enfrentamiento: " . $conexion->error;
            }

            $numEnfrentamiento++;
        }

        echo "Se han creado los enfrentamientos de la segunda ronda.";
    }
} else {
    echo "No hay suficientes ganadores para crear enfrentamientos en la segunda ronda.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>