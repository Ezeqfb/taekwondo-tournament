<?php
//Iniciar la sesión solo si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo '<script>alert("Error en la autenticación: Acceso restringido.");</script>';
    header("Location: LoginORM.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuelas y alumnos</title>
    <link rel="stylesheet" href="../css/crud.css?v=<?php echo time(); ?>">
</head>
<body>
    <div>
        <?php include '../php/header_user.php'; ?>
        <video muted autoplay loop>
            <source src="../img/video.mp4" type="video/mp4">
        </video>
        <div class="capa"></div>
    </div>
    
    <div class="caja">
        <section id="intro_login">
            
            <div id="cajon_login">
            <h1>Creación de escuelas y alumnos</h1>
            <p><b>Paso 1 : </b> Ingrese los participantes con sus respectivas escuelas.
            <br><i>Se requiere completar todos los campos para continuar con el siguiente paso.</i></p>
            <br>
                <form action="guardarDatosORM.php" method="POST">
                    <div id="box_datos">
                        <h2>Agregar escuela 1:</h2>
                        <label for="escuela1">Nombre de la Escuela:</label>
                        <input type="text" name="escuela1" required>
                        <br><br><br>
                        <hr>
                        
                        <h3>Alumnos de Escuela 1</h3>
                        <label for="alumno1_nombre">Nombre del Alumno 1:</label>
                        <input type="text" name="alumno1_nombre1" required>
                        <label for="alumno1_edad">Edad del Alumno 1:</label>
                        <input type="number" name="alumno1_edad1" required>
                        
                        <label for="alumno1_nombre2">Nombre del Alumno 2:</label>
                        <input type="text" name="alumno1_nombre2" required>
                        <label for="alumno1_edad2">Edad del Alumno 2:</label>
                        <input type="number" name="alumno1_edad2" required>
                    </div>
                    <div id="box_info">
                        <h2>Agregar escuela 2:</h2>
                        <label for="escuela2">Nombre de la Escuela:</label>
                        <input type="text" name="escuela2" required>
                        <br><br><br>
                        <hr>
                        
                        <h3>Alumnos de Escuela 2</h3>
                        <label for="alumno2_nombre">Nombre del Alumno 1:</label>
                        <input type="text" name="alumno2_nombre1" required>
                        <label for="alumno2_edad">Edad del Alumno 1:</label>
                        <input type="number" name="alumno2_edad1" required>
                        
                        <label for="alumno2_nombre2">Nombre del Alumno 2:</label>
                        <input type="text" name="alumno2_nombre2" required>
                        <label for="alumno2_edad2">Edad del Alumno 2:</label>
                        <input type="number" name="alumno2_edad2" required>

                    </div>
                    <button type="submit" id="add_alumnos">Siguiente paso</button>
                </form>
                
            </div>
        </section>
    </div>
    <?php include '../php/footer.php'; ?>

    <div id="loader">
        <i class="spinner"></i>
    </div>
    <script src="../js/recarga.js"></script>
</body>
</html>
