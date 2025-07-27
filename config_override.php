<?php
class ConfigOverride {
    public static $BBDD_HOST;
    public static $BBDD_PORT;
    public static $BBDD_USUARIO;
    public static $BBDD_CLAVE;
    public static $BBDD_NOMBRE;

    public static function init() {
        if (getenv('IS_PRODUCTION')) {
            self::$BBDD_HOST = getenv('DB_HOST');
            self::$BBDD_PORT = getenv('DB_PORT') ?: "3306";
            self::$BBDD_USUARIO = getenv('DB_USER');
            self::$BBDD_CLAVE = getenv('DB_PASS');
            self::$BBDD_NOMBRE = getenv('DB_NAME');
        } else {
            require_once 'config.php';
            self::$BBDD_HOST = Config::BBDD_HOST;
            self::$BBDD_PORT = Config::BBDD_PORT;
            self::$BBDD_USUARIO = Config::BBDD_USUARIO;
            self::$BBDD_CLAVE = Config::BBDD_CLAVE;
            self::$BBDD_NOMBRE = Config::BBDD_NOMBRE;
        }
    }

}
