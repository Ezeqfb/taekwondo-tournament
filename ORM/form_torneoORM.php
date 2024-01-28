<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear torneo</title>
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
            <div id="cajon_torneo">
            <h1>Crear nuevo torneo</h1>
            <p>
                <b>Paso 2 : </b>Ingresar nombre del torneo y la fecha de su inicio.
                <br>(La creación del torneo iniciará automáticamente la fase de rondas, una vez finalizado el torneo se podrán visualizar los resultados en el perfil del usuario).
                <br><i>Se requiere completar todos los campos para continuar con el siguiente paso.</i>
            </p>
            <br>
                <div id="box_torneo">
                    <form action="guardarTorneo.php" method="POST">
                        <h2>Nombre del torneo:</h2>
                        <input type="text" id="nombreTorneo" name="nombreTorneo" required><br>
                        <br>
                        <br>
                        <br>
                        <hr>
                        <br>
                        <h2>Fecha del torneo:</h2>
                        <input type="date" id="fechaTorneo" name="fechaTorneo" required><br>
                        <input type="submit" id="add_alumnos" value="¡Comenzar!">
                    </form>
                </div>
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