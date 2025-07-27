<?php
require_once 'config_override.php';

if (getenv('IS_PRODUCTION')) {
    $mysqli = new mysqli(
        ConfigOverride::$BBDD_HOST,
        ConfigOverride::$BBDD_USUARIO,
        ConfigOverride::$BBDD_CLAVE,
        ConfigOverride::$BBDD_NOMBRE,
        ConfigOverride::$BBDD_PORT
    );
} else {
    $mysqli = new mysqli(
        Config::BBDD_HOST,
        Config::BBDD_USUARIO,
        Config::BBDD_CLAVE,
        Config::BBDD_NOMBRE,
        Config::BBDD_PORT
    );
}

class Provincia {
    public $idprovincia;
    public $nombre;

    public function obtenerTodos() {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idprovincia, nombre FROM provincias ORDER BY nombre ASC";
        $aResultado = array();
        if ($resultado = $mysqli->query($sql)) {
            while ($fila = $resultado->fetch_assoc()) {
                $provincia = new Provincia();
                $provincia->idprovincia = $fila["idprovincia"];
                $provincia->nombre = $fila["nombre"];
                $aResultado[] = $provincia;
            }
        }
        $mysqli->close();
        return $aResultado;
    }
}
?>
