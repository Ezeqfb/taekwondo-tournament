<?php
require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/escuelaORM.php');
require_once(__DIR__ . '/Orm.php');
require_once(__DIR__ . '/alumnosORM.php');
require_once(__DIR__ . '/usuariosORM.php');
require_once(__DIR__ . '/escuela_alumnoORM.php');

$database = new Database();
$conexion = $database->getConnection();

$escuelaModel = new Escuela($conexion);
$alumnoModel = new Alumno($conexion);
$usuarioModel = new Usuario($conexion);
$escuelaAlumnoModel = new EscuelaAlumno($conexion);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el ID del usuario que inició sesión
    session_start();
    $usuarioId = $_SESSION['usuario_id'];

    // Obtener datos de las escuelas
    for ($i = 1; $i <= 2; $i++) {
        $escuelaNombre = $_POST["escuela" . $i];
        if (!empty($escuelaNombre)) {
            // Insertar la escuela en la base de datos
            $escuelaId = $escuelaModel->insertEscuela($escuelaNombre, $usuarioId);

            // Obtener datos de los alumnos para esta escuela
            for ($j = 1; $j <= 2; $j++) {
                $alumnoNombre = $_POST["alumno" . $i . "_nombre" . $j];
                if (!empty($alumnoNombre)) {
                    $alumnoEdad = $_POST["alumno" . $i . "_edad" . $j];
                    $alumnoPuntos = rand(1, 10);

                    // Insertar el Alumno en la base de datos
                    $alumnoModel->insertAlumno($alumnoNombre, $alumnoEdad, $alumnoPuntos, $usuarioId);

                    // Relacionar el Alumno con la Escuela en la tabla de relación "escuela_alumno"
                    $escuelaAlumnoModel->insertEA(array(
                        'escuela_id' => $escuelaId,
                        'alumno_id' => $alumnoModel->getLastInsertId()
                    ));
                }
            }
        }
    }

    // Cerrar la conexión
    $database->closeConnection();
    header("Location: form_torneoORM.php");
    exit();
}
?>