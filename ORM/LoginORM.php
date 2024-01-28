<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/login.css?v=<?php echo time(); ?>">
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
                    <h1>Iniciar Sesión</h1>
                    <form action="loginORM.php" method="POST" id="form_login">
                        <h3>Usuario:</h3>
                        <input type="text" name="usuario"><br>
                        <h3>Contraseña:</h3>
                        <input type="password" name="contrasena" maxlenght="16"><br>
                        <input type="submit" value="Iniciar Sesión" id="iniciar">
                    </form>
                    <?php
                    require_once(__DIR__ . '/Database.php');
                    require_once(__DIR__ . '/Orm.php');
                    require_once(__DIR__ . '/usuariosORM.php');

                    $database = new Database();
                    $conexion = $database->getConnection();

                    $usuarioModel = new Usuario($conexion);

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $usuario = $_POST['usuario'];
                        $usuario = strtolower($usuario);
                        $contrasena = $_POST['contrasena'];

                        $fila = $usuarioModel->getUserByName($usuario);

                        if ($fila && array_key_exists('contrasena', $fila)) {
                            if (password_verify($contrasena, $fila['contrasena'])) {
                                session_start();
                                $_SESSION['usuario'] = $usuario;
                                $_SESSION['usuario_id'] = $fila['usuario_id'];

                                header("Location: ../index.php");
                            } else {
                                echo "Contraseña incorrecta.";
                            }
                        } else {
                            echo "Usuario no encontrado.";
                        }
                    }
                    ?>
                    <p>¿No tenes cuenta? <a href="registroORM.php">Registrate aquí</a></p>
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