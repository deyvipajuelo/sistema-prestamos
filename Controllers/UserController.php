<?php

if($peticionAjax){
    require_once('../Models/UserModel.php');
}else {
    require_once('./Models/UserModel.php');
}

class UserController extends UserModel{
    /* ---------- Controlador Agregar Usuario ---------- */
    public function addUserController(){

        $dni = MainModel::cleanString($_POST['usuario_dni_reg']);
        $nombre = MainModel::cleanString($_POST['usuario_nombre_reg']);
        $apellido = MainModel::cleanString($_POST['usuario_apellido_reg']);
        $telefono = MainModel::cleanString($_POST['usuario_telefono_reg']);
        $direccion = MainModel::cleanString($_POST['usuario_direccion_reg']);
        
        $usuario = MainModel::cleanString($_POST['usuario_usuario_reg']);
        $email = MainModel::cleanString($_POST['usuario_email_reg']);
        $clave1 = MainModel::cleanString($_POST['usuario_clave_1_reg']);
        $clave2 = MainModel::cleanString($_POST['usuario_clave_2_reg']);

        $privilegio = MainModel::cleanString($_POST['usuario_privilegio_reg']);
        
        /* ---------- Comprobar campos vacios ---------- */
        if ($dni == '' || $nombre == '' || $apellido == '' || $usuario == '' || $clave1 == '' || $clave2 == '') {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "No has llenado todos los campos obligatorios",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        if (MainModel::verifyData("[0-9]{8}",$dni)) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "El número de dni no es válido",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }
        
    }
}