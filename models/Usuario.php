<?php

namespace Model;

class Usuario extends ActiveRecord{
    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password',
    'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';

    }
    // Mensajes de validacion para la creacion de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'Debes ingresar un nombre';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'Debes ingresar un apellido';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'Debes ingresar un email';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes ingresar una contraseña';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Debe contener mínimo 6 caracteres';
        }


        return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email) {
            self::$alertas['error'][] = 'Debes ingresar un email';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes ingresar una contraseña';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email) {
            self::$alertas['error'][] = 'Debes ingresar un email';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes ingresar una contraseña';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Debe contener mínimo 6 caracteres';
        }

        return self::$alertas;
    }

    //Revisa si existe el Usuario
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El email ya existe en el sistema';
        }
        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid('', true);
    }

    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        }else{
            return true;
        }
    }
}