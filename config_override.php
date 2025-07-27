<?php
class ConfigOverride {
    public static $BBDD_HOST;
    public static $BBDD_PORT;
    public static $BBDD_USUARIO;
    public static $BBDD_CLAVE;
    public static $BBDD_NOMBRE;

    public static function init() {
        self::$BBDD_HOST = getenv('DB_HOST') ?: '127.0.0.1';
        self::$BBDD_PORT = getenv('DB_PORT') ?: '3306';
        self::$BBDD_USUARIO = getenv('DB_USER') ?: 'root';
        self::$BBDD_CLAVE = getenv('DB_PASS') ?: '';
        self::$BBDD_NOMBRE = getenv('DB_NAME') ?: 'abmventas';
    }
}

ConfigOverride::init();
?>
