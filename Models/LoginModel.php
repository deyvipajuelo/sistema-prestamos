<?php

require_once('MainModel.php');

class LoginModel extends MainModel{

    /* ---------- Modelo para iniciar sesión ---------- */
    protected static function login($data){
        $sql = MainModel::connect()->prepare("SELECT * FROM usuario WHERE usuario_usuario = :user AND usuario_clave = :psw AND usuario_estado = 'activo'");
        $sql->bindParam(':user',$data['user']);
        $sql->bindParam(':psw',$data['password']);        
        $sql->execute();
        return $sql;
    }
}