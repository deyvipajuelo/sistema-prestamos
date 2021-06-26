<?php

// if($peticionAjax){
    require_once('../Models/UserModel.php');
// }else {
//     require_once('./Models/UserModel.php');
// }

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
        
        
        /* ---------- Comprobando que los campos sean válidos ---------- */
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
        
        if (MainModel::verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}",$nombre)) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "Ingrese su nombre",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        if (MainModel::verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}",$apellido)) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "Ingrese su apellido",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        if (MainModel::verifyData("[a-zA-Z0-9]{1,35}" ,$usuario)) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "El nombre de usuario no es válido",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        if (MainModel::verifyData("[a-zA-Z0-9$@.-]{7,100}" ,$clave1) || MainModel::verifyData("[a-zA-Z0-9$@.-]{7,100}" ,$clave2)) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "Ingrese una contraseña válida",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        if ($telefono != "") {
            if (MainModel::verifyData("[0-9()+]{8,20}" ,$telefono)) {
                $alerta = [
                    "Alert" => "simple",
                    "Title" => "Ocurrió un error inesperado",
                    "Text" => "Ingrese un teléfono válido",
                    "Type" => "error"
                ];
    
                echo(json_encode($alerta));
                exit();
            }
        }

        if ($direccion != "") {
            if (MainModel::verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" ,$direccion)) {
                $alerta = [
                    "Alert" => "simple",
                    "Title" => "Ocurrió un error inesperado",
                    "Text" => "Ingrese una dirección válida",
                    "Type" => "error"
                ];
    
                echo(json_encode($alerta));
                exit();
            }
        }

        /* ---------- Comprobando que el DNI sea único ---------- */
        $checkDni = MainModel::runSimpleQuery("SELECT usuario_dni FROM usuario WHERE usuario_dni = $dni");
        if ($checkDni->rowCount() > 0) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "El DNI ya se encuentra registrado",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        /* ---------- Comprobando que el usuario sea único ---------- */
        $checkUser = MainModel::runSimpleQuery("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
        if ($checkUser->rowCount() > 0) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "El nombre de usuario no está disponible",
                "Type" => "error"
            ];

            echo(json_encode($alerta));
            exit();
        }

        /* ---------- Comprobando que el email sea único ---------- */
        if ($email !== "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $checkEmail = MainModel::runSimpleQuery("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
                if ($checkEmail->rowCount() > 0) {
                    $alerta = [
                        "Alert" => "simple",
                        "Title" => "Ocurrió un error inesperado",
                        "Text" => "El email ya se encuentra registrado",
                        "Type" => "error"
                    ];
                    
                    echo(json_encode($alerta));
                    exit();
                }
            }else {
                $alerta = [
                    "Alert" => "simple",
                    "Title" => "Ocurrió un error inesperado",
                    "Text" => "Ingrese un email válido",
                    "Type" => "error"
                ];
            
                echo(json_encode($alerta));
                exit();
            }

        }
        
        /* ---------- Comprobando que los passwords son iguales ---------- */
        if ($clave1 !== $clave2) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "Las contraseñas no coinciden",
                "Type" => "error"
            ];
        
            echo(json_encode($alerta));
            exit();
        }else {
            $clave = MainModel::encryption($clave1);
        }
        
        /* ---------- Comprobando que los passwords son iguales ---------- */
        if ($privilegio < 1 || $privilegio > 3) {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "El privilegio no es válido",
                "Type" => "error"
            ];
        
            echo(json_encode($alerta));
            exit();
        }

        $dataNewUser = [
            'DNI' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email,
            'usuario' => $usuario,
            'clave' => $clave,
            'estado' => 'activo',
            'privilegio' => $privilegio
        ];
        
        $addNewUser = UserModel::addUserModel($dataNewUser);

        if ($addNewUser->rowCount() === 1) {
            $alerta = [
                "Alert" => "clean",
                "Title" => "Usuario registrado",
                "Text" => "Usuario registrado con éxito",
                "Type" => "success"
            ];
        
            echo(json_encode($alerta));
            exit();
        }else {
            $alerta = [
                "Alert" => "simple",
                "Title" => "Ocurrió un error inesperado",
                "Text" => "No se ha podido registrar al usuario, inténtelo nuevamente",
                "Type" => "error"
            ];
        
            echo(json_encode($alerta));
            exit();
        }
        
    } // End addUserController
} 