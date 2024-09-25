<?php

namespace Model;

class Servicio extends ActiveRecord{
    //Base de Datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        
    }

    public function validar(){
        if(!$this->nombre) {
            self::$errores[] = "Debes ingresar un nombre para el servicio";
        }
        if(!$this->precio) {
            self::$errores[] = "Debes ingresar el precio para el servicio";
        }

        if(!is_numeric($this->precio)) {
            self::$errores[] = "Debes ingresar un nombre para el servicio";
        }

        return self::$alertas;
    }
}