<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div>
        <?php include 'php/header.php'; ?>
        <video muted autoplay loop>
            <source src="img/video.mp4" type="video/mp4">
        </video>
        <div class="capa"></div>
    </div>
    
    <div class="caja">
        <section id="intro">
            <h1>
                ¡<span>Zarate-Kid</span>!
            </h1>
            <h2>
                Taekwondo Tournament Manager
            </h2>
            <p>Te brindamos la posibilidad de generar tu torneo con las herramientas necesarias para elegir un potencial ganador. Podes empezar a organizar tu torneo ahora mismo, con un solo click. </p>
            <a href="ORM/cargarDatosORM.php" class="btn"><button>CREAR UN TORNEO</button></a>
        </section>
        <div id="sec2">
            <div class="faq-container">
                <section class="faq-section">
                    <div class="faq-inner">
                        
                        <h1>¿Cómo funciona la creación de torneos?</h1>

                        <div class="faq-item">
                            <div class="circle">1</div>
                            <div class="question">- Primer paso:</div>
                            <div class="answer"><p>Para comenzar, debe insertar los alumnos y escuelas en primer formulario para la creación del torneo. Asegúrate de llenar los datos necesarios y sigue los pasos indicados en la interfaz.</p></div>
                        </div>

                        <div class="faq-item">
                            <div class="circle">2</div>
                            <div class="question">- Segundo paso:</div>
                            <div class="answer"><p>Para crear el torneo se debe especificar los detalles del torneo, como el nombre y la fecha en la que se realizará el mismo.</p></div>
                        </div>

                        <div class="faq-item">
                            <div class="circle">3</div>
                            <div class="question">- Tercer paso:</div>
                            <div class="answer"><p>Al finalizar con la creación del torneo es <i>importante</i> comenzar la fase de rondas y seguir los resultados, cada click a la siguiente ronda indicarán los puntos de cada participante.</p></div>
                        </div>

                        <div class="faq-item">
                            <div class="circle">4</div>
                            <div class="question">- Cuarto paso:</div>
                            <div class="answer"><p>Último paso, en la ronda final queda por establecer como finalizado el torneo, esto te llevará a visualizar la tabla final de resultados. Puedes volver a mirar los resultados en tu perfil.</p></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
            
        </div>
        <section id="centrar_orden_box1">
            <div id="orden_box1">
                <div class="box1">
                    <a href="baku.php" class="btn">
                        <img src="img/baku.png" alt="baku">
                        <p> Noticia: Ganadores del mundial 2023 </p>
                    </a>
                </div>
                <div class="box1">
                    <a href= "ulp.php" class="btn">
                        <img src="img/ulp.jpg" alt="ulp">
                        <p> Noticia: Capacitacion de arbitral en la ULP </p>
                    </a>
                </div>
                <div class="box1">
                    <a href="selecar.php" class="btn">
                        <img src="img/arg.jpg" alt="arg">
                        <p> Noticia: Seleccionado argentino hace historia </p>
                    </a>
                </div>
            </div>
        </section>
        
        <div id="sec1">
        </div>
        
    </div>

    <?php include 'php/footer.php'; ?>
    
    <div id="loader">
        <i class="spinner"></i>
    </div>
    <script src="js/recarga.js"></script>
</body>
</html>