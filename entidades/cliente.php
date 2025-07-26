<?php

class Cliente
{
    public $idcliente;
    public $nombre;
    public $cuit;
    public $correo;
    public $telefono;
    public $fecha_nac;
    public $provincia;
    public $fk_idprovincia;
    public $domicilio;


    public function cargarFormulario($request)
    {
        $this->idcliente = isset($request["id"]) ? $request["id"] : "";
        $this->nombre = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->cuit = isset($request["txtCuit"]) ? $request["txtCuit"] : "";
        $this->correo = isset($request["txtCorreo"]) ? $request["txtCorreo"] : "";
        $this->telefono = isset($request["txtTelefono"]) ? $request["txtTelefono"] : "";
        $this->fecha_nac = isset($request["txtFechaNac"]) ? $request["txtFechaNac"] : "";
        $this->fk_idprovincia = isset($request["lstProvincia"]) ? $request["lstProvincia"] : "";
    }

    public function insertar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "INSERT INTO clientes (nombre, cuit, correo, telefono, fecha_nac) VALUES (
            '$this->nombre',
            '$this->cuit',
            '$this->correo',
            '$this->telefono',
            '$this->fecha_nac'
            $this->fk_idprovincia
        );";
        $mysqli->query($sql);
        $this->idcliente = $mysqli->insert_id;
        $mysqli->close();
    }

    public function actualizar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "UPDATE clientes SET
            nombre = '$this->nombre',
            cuit = '$this->cuit',
            correo = '$this->correo',
            telefono = '$this->telefono',
            fecha_nac = '$this->fecha_nac',
            fk_idprovincia = $this->fk_idprovincia
            WHERE idcliente = $this->idcliente";
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function eliminar()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "DELETE FROM clientes WHERE idcliente = " . $this->idcliente;
        $mysqli->query($sql);
        $mysqli->close();
    }

    public function obtenerPorId()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT idcliente, nombre, cuit, correo, telefono, fecha_nac, fk_idprovincia FROM clientes WHERE idcliente = " . $this->idcliente;
        $resultado = $mysqli->query($sql);
        if ($fila = $resultado->fetch_assoc()) {
            $this->idcliente = $fila["idcliente"];
            $this->nombre = $fila["nombre"];
            $this->cuit = $fila["cuit"];
            $this->correo = $fila["correo"];
            $this->telefono = $fila["telefono"];
            $this->fecha_nac = $fila["fecha_nac"];
            $this->fk_idprovincia = $fila["fk_idprovincia"];
        }
        $mysqli->close();
        return $this;
    }

    public function obtenerTodos()
    {
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE, Config::BBDD_PORT);
        $sql = "SELECT 
                    c.idcliente, 
                    c.nombre, 
                    c.cuit, 
                    c.correo, 
                    c.telefono, 
                    c.fecha_nac, 
                    c.fk_idprovincia, 
                    p.nombre AS provincia
                FROM clientes c
                LEFT JOIN provincias p ON c.fk_idprovincia = p.idprovincia
                ORDER BY c.nombre ASC";
        $resultado = $mysqli->query($sql);
        $aResultado = array();
        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $cliente = new Cliente();
                $cliente->idcliente = $fila["idcliente"];
                $cliente->nombre = $fila["nombre"];
                $cliente->cuit = $fila["cuit"];
                $cliente->correo = $fila["correo"];
                $cliente->telefono = $fila["telefono"];
                $cliente->fecha_nac = $fila["fecha_nac"];
                $cliente->fk_idprovincia = $fila["fk_idprovincia"];
                $cliente->provincia = $fila["provincia"]; // Nueva propiedad
                $aResultado[] = $cliente;
            }
        }
        $mysqli->close();
        return $aResultado;
    }
}
