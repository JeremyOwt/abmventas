<?php
require_once __DIR__ . '/config.php'; // Ruta al config base
require_once __DIR__ . '/config_override.php'; // Ruta al override para producción

function obtenerConexion() {
    if (getenv('IS_PRODUCTION')) {
        $host = ConfigOverride::$BBDD_HOST;
        $usuario = ConfigOverride::$BBDD_USUARIO;
        $clave = ConfigOverride::$BBDD_CLAVE;
        $nombre = ConfigOverride::$BBDD_NOMBRE;
        $puerto = ConfigOverride::$BBDD_PORT;
    } else {
        $host = Config::BBDD_HOST;
        $usuario = Config::BBDD_USUARIO;
        $clave = Config::BBDD_CLAVE;
        $nombre = Config::BBDD_NOMBRE;
        $puerto = Config::BBDD_PORT;
    }

    $conexion = new mysqli($host, $usuario, $clave, $nombre, $puerto);

    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    return $conexion;
}
?>
