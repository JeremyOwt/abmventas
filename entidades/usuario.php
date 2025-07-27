<?php
require_once __DIR__ . '/../conexion.php';

class Usuario {
    private $idusuario;
    private $usuario;
    private $clave;
    private $nombre;
    private $apellido;
    private $correo;

    public function __construct(){

    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }


    public function cargarFormulario($request){
        $this->idusuario = isset($request["id"])? $request["id"] : "";
        $this->usuario = isset($request["txtUsuario"])? $request["txtUsuario"] : "";
        $this->clave = isset($request["txtClave"]) && $request["txtClave"] != "" ? $this->encriptarClave($request["txtClave"]) : "";
        $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
        $this->apellido = isset($request["txtApellido"])? $request["txtApellido"]: "";
        $this->correo = isset($request["txtCorreo"])? $request["txtCorreo"]: "";
    }

    public function insertar(){
        $mysqli = obtenerConexion();
        $sql = "INSERT INTO usuarios (
                    usuario, 
                    clave, 
                    nombre,
                    apellido, 
                    correo
                ) VALUES (
                    '" . $this->usuario ."', 
                    '" . $this->clave ."', 
                    '" . $this->nombre ."',
                    '" . $this->apellido ."',
                    '" . $this->correo ."'
                );";
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $this->idusuario = $mysqli->insert_id;
        $mysqli->close();
    }

    public function actualizar(){
        $mysqli = obtenerConexion();
        $sql = "";

        if($this->clave != ""){
            $sql = "UPDATE usuarios SET
                usuario = '$this->usuario',
                nombre = '$this->nombre',
                apellido = '$this->apellido',
                clave = '$this->clave',
                correo = '$this->correo'
                WHERE idusuario = " . $this->idusuario;
        } else {
            $sql = "UPDATE usuarios SET
                usuario = '$this->usuario',
                nombre = '$this->nombre',
                apellido = '$this->apellido',
                correo = '$this->correo'
                WHERE idusuario = " . $this->idusuario;
        }
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = obtenerConexion();
        $sql = "DELETE FROM usuarios WHERE idusuario = " . $this->idusuario;
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = obtenerConexion();
        $sql = "SELECT idusuario, 
                        usuario, 
                        clave,
                        nombre,
                        apellido, 
                        correo
                FROM usuarios 
                WHERE idusuario = " . $this->idusuario;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        if($fila = $resultado->fetch_assoc()){
            $this->idusuario = $fila["idusuario"];
            $this->usuario = $fila["usuario"];
            $this->clave = $fila["clave"];
            $this->nombre = $fila["nombre"];
            $this->apellido = $fila["apellido"];
            $this->correo = $fila["correo"];
        }
        $mysqli->close();
    }

    public function obtenerPorUsuario($usuario, $idusuario=""){
        $mysqli = obtenerConexion();
        $sql = "SELECT idusuario, 
                        usuario, 
                        clave,
                        nombre,
                        apellido, 
                        correo
                FROM usuarios 
                WHERE usuario = '$usuario' AND idusuario <> '$idusuario'";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        if($fila = $resultado->fetch_assoc()){
            $this->idusuario = $fila["idusuario"];
            $this->usuario = $fila["usuario"];
            $this->clave = $fila["clave"];
            $this->nombre = $fila["nombre"];
            $this->apellido = $fila["apellido"];
            $this->correo = $fila["correo"];
            return true;
        } else {
            return false;
        }
        $mysqli->close();
    }

    public function obtenerPorCorreo($correo, $idusuario=""){
        $mysqli = obtenerConexion();
        $sql = "SELECT idusuario, 
                        usuario, 
                        clave,
                        nombre,
                        apellido, 
                        correo
                FROM usuarios 
                WHERE correo = '$correo' AND idusuario <> '$idusuario'";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        if($fila = $resultado->fetch_assoc()){
            $this->idusuario = $fila["idusuario"];
            $this->usuario = $fila["usuario"];
            $this->clave = $fila["clave"];
            $this->nombre = $fila["nombre"];
            $this->apellido = $fila["apellido"];
            $this->correo = $fila["correo"];
            return true;
        } else {
            return false;
        }
        $mysqli->close();
    }

    public function obtenerTodos(){
        $mysqli = obtenerConexion();
        $sql = "SELECT idusuario, usuario, clave, nombre, apellido, correo FROM usuarios";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $aResultado = array();
        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $entidadAux = new Usuario();
                $entidadAux->idusuario = $fila["idusuario"];
                $entidadAux->usuario = $fila["usuario"];
                $entidadAux->clave = $fila["clave"];
                $entidadAux->nombre = $fila["nombre"];
                $entidadAux->apellido = $fila["apellido"];
                $entidadAux->correo = $fila["correo"];
                $aResultado[] = $entidadAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }

    public function encriptarClave($clave){
        return password_hash($clave, PASSWORD_DEFAULT);
    }

    public function verificarClave($claveIngresada, $claveEnBBDD){
        return password_verify($claveIngresada, $claveEnBBDD);
    }
}
?>
