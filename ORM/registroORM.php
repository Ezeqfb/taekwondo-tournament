

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/register.css?v=<?php echo time(); ?>">
</head>
<body>
    <div>
    <?php include '../php/header_login.php'; ?>
        <video muted autoplay loop>
            <source src="../img/video.mp4" type="video/mp4">
        </video>
        <div class="capa"></div>
    </div>
    
    <div class="caja">
        <section id="intro_login">
            <div id="cajon_login">
                <div id="box_datos">
                    <h1>Registrarse</h1>
                    <form action="registroORM.php" method="POST" id="form_login">
                        <h3>Usuario:</h3>
                        <input type="text" name="usuario" maxlength="16" required><br>
                        <h3>Contraseña:</h3>
                        <input type="password" name="contrasena" maxlength="16" required><br>
                        <input type="submit" value="Registrarse" id="iniciar">
                    </form>
                    <?php
                    require_once(__DIR__ . '/Database.php');
                    require_once(__DIR__ . '/Orm.php');
                    require_once(__DIR__ . '/usuariosORM.php');

                    $database = new Database();
                    $conexion = $database->getConnection();

                    $usuarioModel = new Usuario($conexion);

                    // Variables para mensajes
                    $mensajeError = "";
                    $mensajeExito = "";

                    // INSERT PARA USUARIOS
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $usuario = $_POST['usuario'];
                        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

                        // Convertir el nombre de usuario a minúsculas (o mayúsculas) antes de realizar la verificación
                        $usuario = strtolower($usuario);

                        // Verificar si el usuario ya existe
                        if ($usuarioModel->usuarioExists($usuario)) {
                            $mensajeError = "Este nombre de usuario ya está registrado. Por favor, intente nuevamente con otro nombre.";
                        } else {
                            // Insertar el nuevo usuario solo si no existe
                            $usuarioModel->insertUsuario($usuario, $contrasena);
                            $mensajeExito = "Cuenta creada exitosamente. ¡Ahora puedes <a href='LoginORM.php'>iniciar sesión</a>!";
                        }
                    }
                    ?>

                    <script>
                        function mostrarMensajes() {
                            //Muestra un alert con el mensaje de éxito si está definido
                            var mensajeExito = '<?php echo isset($usuarioModel->mensajeExito) ? $usuarioModel->mensajeExito : ''; ?>';
                            if (mensajeExito && mensajeExito !== '') {
                                alert(mensajeExito);
                                window.location.href = 'LoginORM.php';
                            }

                            //Muestra un alert con el mensaje de error si está definido
                            var mensajeError = '<?php echo isset($usuarioModel->mensajeError) ? $usuarioModel->mensajeError : ''; ?>';
                            if (mensajeError && mensajeError !== '') {
                                alert(mensajeError);
                            }
                        }
                        //Asociar la función mostrarMensajes al evento load del documento
                        document.addEventListener('DOMContentLoaded', mostrarMensajes);
                    </script>

                    <p>¿Ya tenes cuenta? <a href="loginORM.php">Iniciar sesión</a></p>
                </div>
                <div id="box_info">
                    <p>Inicia sesión para comenzar a crear tu torneo. Registrate si no tienes una cuenta.</p>
                    <img src="../img/logo.png" alt="Jorgito">
                </div>
            </div>
        </section>
        <section id="centrar_orden_box1">
            <div id="orden_box1">
                <div class="box1">
                    <a href="../baku.php" class="btn">
                        <img src="../img/baku.png" alt="baku">
                        <p> Ganadores del mundial 2023 </p>
                    </a>
                </div>
                <div class="box1">
                    <a href= "../ulp.php" class="btn">
                        <img src="../img/ulp.jpg" alt="ulp">
                        <p> Capacitacion de arbitral en la ULP </p>
                    </a>
                </div>
                <div class="box1">
                    <a href="../selecar.php" class="btn">
                        <img src="../img/arg.jpg" alt="arg">
                        <p> Seleccionado argentino hace historia </p>
                    </a>
                </div>
            </div>
        </section>
        
        <div id="sec1">
        </div>
        
    </div>

    <?php include '../php/footer.php'; ?>
    
    <div id="loader">
        <i class="spinner"></i>
    </div>
    <script src="../js/recarga.js"></script>
</body>
</html>