<?php
require_once __DIR__ . '/../conexion.php';  // Ajustá la ruta según dónde tengas conexion.php

class Venta {
    private $idventa;
    private $fk_idcliente;
    private $fk_idproducto;
    private $fecha;
    private $cantidad;
    private $preciounitario;
    private $total;

    private $nombre_cliente;
    private $nombre_producto;

    public function __construct(){
        $this->cantidad = 0;
        $this->preciounitario = 0.0;
        $this->total = 0.0;
    }

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }

    public function cargarFormulario($request){
        $this->idventa = isset($request["id"])? $request["id"] : "";
        $this->fk_idcliente = isset($request["lstCliente"])? $request["lstCliente"] : "";
        $this->fk_idproducto = isset($request["lstProducto"])? $request["lstProducto"]: "";
        if(isset($request["txtAnio"]) && isset($request["txtMes"]) && isset($request["txtDia"])){
            $this->fecha = $request["txtAnio"] . "-" .  $request["txtMes"] . "-" .  $request["txtDia"] . " " . $request["txtHora"];
        }
        $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"] : 0;
        $this->preciounitario = isset($request["txtPrecioUni"])? $request["txtPrecioUni"] : 0.0;
        $this->total = $this->preciounitario * $this->cantidad;
    }

    public function insertar(){
        $mysqli = obtenerConexion();
        $sql = "INSERT INTO ventas (
                    fk_idcliente, 
                    fk_idproducto, 
                    fecha, 
                    cantidad,
                    preciounitario,
                    total
                ) VALUES (
                    $this->fk_idcliente, 
                    $this->fk_idproducto,
                    '$this->fecha', 
                    $this->cantidad,
                    $this->preciounitario,
                    $this->total
                );";
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $this->idventa = $mysqli->insert_id;
        $mysqli->close();
    }

    public function actualizar(){
        $mysqli = obtenerConexion();
        $sql = "UPDATE ventas SET
                    fk_idcliente = $this->fk_idcliente,
                    fk_idproducto = $this->fk_idproducto,
                    fecha = '$this->fecha',
                    cantidad = $this->cantidad,
                    preciounitario = $this->preciounitario,
                    total = $this->total
                WHERE idventa = $this->idventa";
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function eliminar(){
        $mysqli = obtenerConexion();
        $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorId(){
        $mysqli = obtenerConexion();
        $sql = "SELECT  idventa, 
                        fk_idcliente, 
                        fk_idproducto, 
                        fecha, 
                        cantidad,
                        preciounitario,
                        total
                FROM ventas 
                WHERE idventa = " . $this->idventa;
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        if($fila = $resultado->fetch_assoc()){
            $this->idventa = $fila["idventa"];
            $this->fk_idcliente = $fila["fk_idcliente"];
            $this->fk_idproducto = $fila["fk_idproducto"];
            $this->fecha = $fila["fecha"];
            $this->cantidad = $fila["cantidad"];
            $this->preciounitario = $fila["preciounitario"];
            $this->total = $fila["total"];
        }
        $mysqli->close();
    }
    
    public function obtenerTodos(){
        $mysqli = obtenerConexion();
        $sql = "SELECT idventa, 
                        fk_idcliente, 
                        fk_idproducto, 
                        fecha, 
                        cantidad,
                        preciounitario,
                        total
                FROM ventas";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $aResultado = array();
        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $entidadAux = new Venta();
                $entidadAux->idventa = $fila["idventa"];
                $entidadAux->fk_idcliente = $fila["fk_idcliente"];
                $entidadAux->fk_idproducto = $fila["fk_idproducto"];
                $entidadAux->fecha = $fila["fecha"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->preciounitario = $fila["preciounitario"];
                $entidadAux->total = $fila["total"];
                $aResultado[] = $entidadAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }

    public function cargarGrilla(){
        $mysqli = obtenerConexion();
        $sql = "SELECT 
                    V.idventa,
                    V.fecha,
                    V.cantidad, 
                    V.fk_idproducto, 
                    P.nombre AS nombre_producto, 
                    V.fk_idcliente, 
                    C.nombre AS nombre_cliente, 
                    V.total  
                FROM ventas V
                INNER JOIN clientes C ON C.idcliente = V.fk_idcliente 
                INNER JOIN productos P ON P.idproducto = V.fk_idproducto";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $aResultado = array();
        if($resultado){
            while($fila = $resultado->fetch_assoc()){
                $entidadAux = new Venta();
                $entidadAux->idventa = $fila["idventa"];
                $entidadAux->fk_idcliente = $fila["fk_idcliente"];
                $entidadAux->fk_idproducto = $fila["fk_idproducto"];
                $entidadAux->fecha = $fila["fecha"];
                $entidadAux->cantidad = $fila["cantidad"];
                $entidadAux->total = $fila["total"];
                $entidadAux->nombre_producto = $fila["nombre_producto"];
                $entidadAux->nombre_cliente = $fila["nombre_cliente"];
                $aResultado[] = $entidadAux;
            }
        }
        $mysqli->close();
        return $aResultado;
    }

    public function obtenerFacturacionMensual($mesActual, $anioActual){
        $mysqli = obtenerConexion();
        $sql = "SELECT SUM(total) AS cantidad FROM ventas 
                WHERE MONTH(fecha) = $mesActual AND YEAR(fecha) = $anioActual;";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $sumarizacion = 0;
        if ($fila = $resultado->fetch_assoc()) {
            $sumarizacion = $fila["cantidad"] > 0 ? $fila["cantidad"] : 0;
        }
        $mysqli->close();
        return $sumarizacion;
    }
    
    public function obtenerFacturacionAnual($anioActual){
        $mysqli = obtenerConexion();
        $sql = "SELECT SUM(total) AS cantidad FROM ventas 
                WHERE YEAR(fecha) = '$anioActual';";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $sumarizacion = 0;
        if ($fila = $resultado->fetch_assoc()) {
            $sumarizacion = $fila["cantidad"] > 0 ? $fila["cantidad"] : 0;
        }
        $mysqli->close();
        return $sumarizacion;
    }

    public function obtenerFacturacionPorPeriodo($fechaDesde, $fechaHasta){
        $mysqli = obtenerConexion();
        $sql = "SELECT SUM(total) AS sumarizacion FROM ventas WHERE fecha >= '$fechaDesde' AND fecha <= '$fechaHasta 23:59:59';";
        if (!$resultado = $mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $sumarizacion = 0;
        if ($fila = $resultado->fetch_assoc()) {
            $sumarizacion = $fila["sumarizacion"] > 0 ? $fila["sumarizacion"] : 0;
        }
        $mysqli->close();
        return $sumarizacion;
    }

    public function obtenerVentasPorCliente($idCliente) {
        $aVentas = array();
        $mysqli = obtenerConexion();
        $sql = "SELECT * FROM ventas WHERE fk_idcliente = " . intval($idCliente);
        $resultado = $mysqli->query($sql);
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $aVentas[] = $row;
            }
        }
        $mysqli->close();
        return $aVentas;
    }
}
?>
