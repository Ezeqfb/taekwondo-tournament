<?php
require_once 'conexion.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el ID del usuario que inició sesión
    $usuarioId = $_SESSION['usuario_id'];

    // Inicializar las variables de índice
    $escuelaIndex = 1;
    $alumnoIndex = 1;

    // Obtener datos de las escuelas
    for ($i = 1; $i <= 2; $i++) {
        $escuelaNombre = $_POST["escuela" . $i];
        if (!empty($escuelaNombre)) {
            // Insertar la escuela en la base de datos
            $sql = "INSERT INTO escuelas (nombreEscuela, usuario_id) VALUES ('$escuelaNombre', $usuarioId)";
            if ($conexion->query($sql) === false) {
                echo "Error al crear la Escuela: " . $conexion->error;
            } else {
                $escuelaId = $conexion->insert_id;

                // Obtener datos de los alumnos para esta escuela
                for ($j = 1; $j <= 2; $j++) {
                    $alumnoNombre = $_POST["alumno" . $escuelaIndex . "_nombre" . $alumnoIndex];
                    if (!empty($alumnoNombre)) {
                        $alumnoEdad = $_POST["alumno" . $escuelaIndex . "_edad" . $alumnoIndex];
                        $alumnoPuntos = rand(1, 10);

                        // Insertar el Alumno en la base de datos
                        $sql = "INSERT INTO alumnos (nombre, edad, puntos, usuario_id) VALUES ('$alumnoNombre', $alumnoEdad, $alumnoPuntos, $usuarioId)";
                        if ($conexion->query($sql) === false) {
                            echo "Error al crear el Alumno: " . $conexion->error;
                        } else {
                            $alumnoId = $conexion->insert_id;

                            // Relacionar el Alumno con la Escuela en la tabla de relación "escuela_alumno"
                            $sql = "INSERT INTO escuela_alumno (escuela_id, alumno_id) VALUES ($escuelaId, $alumnoId)";
                            if ($conexion->query($sql) === false) {
                                echo "Error al relacionar la Escuela y el Alumno: " . $conexion->error;
                            } else {
                                echo "Los datos se han guardado en la base de datos.";
                            }
                        }
                    }
                    // Incrementar el índice de alumnos
                    $alumnoIndex++;
                }
                // Reiniciar el índice de alumnos para la siguiente escuela
                $alumnoIndex = 1;
            }
            // Incrementar el índice de escuelas
            $escuelaIndex++;
        }
    }

    // Cerrar la conexión
    mysqli_close($conexion);
    header("Location: ../form_torneo.php");
    exit();
}
?>