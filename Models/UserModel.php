<?php

require_once('MainModel.php');

class UserModel extends MainModel{
    /* ---------- Modelo Agregar Usuario ---------- */
    protected static function addUserModel($data){
        $sql = MainModel::connect()->prepare('INSERT INTO usuario(usuario_dni, usuario_nombre, usuario_apellido, usuario_telefono, usuario_direccion, usuario_email, usuario_usuario, usuario_clave, usuario_estado, usuario_privilegio) VALUES(:DNI, :nombre, :apellido, :telefono, :direccion, :email, :usuario, :clave, :estado, :privilegio)');

        $sql->bindParam(':DNI', $data['DNI']);
        $sql->bindParam(':nombre', $data['nombre']);
        $sql->bindParam(':apellido', $data['apellido']);
        $sql->bindParam(':telefono', $data['telefono']);
        $sql->bindParam(':direccion', $data['direccion']);
        $sql->bindParam(':email', $data['email']);
        $sql->bindParam(':usuario', $data['usuario']);
        $sql->bindParam(':clave', $data['clave']);
        $sql->bindParam(':estado', $data['estado']);
        $sql->bindParam(':privilegio', $data['privilegio']);
        $sql->execute();

        return $sql;
    }
}