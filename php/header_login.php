<?php
// Include de la clase Database
include '../ORM/Database.php';

// Iniciar la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo '<header class="cabecera">
    <div class="logo">
    <img src="../img/logo.png" alt="Logo">
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="../index.php#sec2">Acerca de</a></li>
            <li><a href="../index.php">Inicio</a></li>';

if (isset($_SESSION['usuario_id'])) {
    $db = new Database();
    
    //Obtener el nombre del usuario
    $usuarioId = $_SESSION['usuario_id'];
    $nombreUsuario = obtenerNombreDeUsuarioDesdeBD($db, $usuarioId);

    //Mostrar el nombre del usuario y opciones de cierre de sesión
    echo '<li class="usuario-menu">
    <a href="#" id="pibe">' . $nombreUsuario . '</a>
    <ul class="submenu">
        <li><a href="../php/cerrar_sesion.php">Perfil</a></li>
        <li><a href="../php/cerrar_sesion.php">Salir</a></li>
    </ul>
    </li>';

    $db->closeConnection();
} else {
    //Mostrar el enlace de inicio de sesión y registro
    echo '<li><a href="../ORM/LoginORM.php">Iniciar Sesión</a></li>';
    echo '<li><a href="../ORM/RegistroORM.php">Registrarse</a></li>';
}

echo '</ul>
    </nav>
</header>';

// Función para obtener el nombre de usuario desde la base de datos
function obtenerNombreDeUsuarioDesdeBD($db, $usuarioId) {
    $query = "SELECT usuario FROM usuarios WHERE usuario_id = ?";
    
    // Preparar la consulta
    $stmt = $db->getConnection()->prepare($query);
    $stmt->execute([$usuarioId]);
    
    // Obtener el resultado
    $result = $stmt->fetchColumn();
    
    // Cerrar la declaración
    $stmt->closeCursor();

    return $result;
}
?>