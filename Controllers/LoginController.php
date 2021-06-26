<?php

// if ($peticionAjax) {
//     # code...
// } else {
    require_once('Models/LoginModel.php');
// }

class LoginController extends LoginModel{

    /* ---------- Funcion iniciar sesión ---------- */
    public function login_controller(){
        $user = MainModel::cleanString($_POST['user']);
        $password = MainModel::cleanString($_POST['password']);

        if ($user === '' || $password === '') {
            echo('<script>
                Swal.fire({
                    title: "Error",
                    text: "Ingresa tu usuario y contraseña",
                    type: "error",
                    confirmButtonText: "Aceptar"
                })
            </script>');
        }

        $pass = MainModel::encryption($password);

        $dataLogin = [
            'user' => $user,
            'password' => $pass
        ];

        $dataAcountLogin = LoginModel::login($dataLogin);

        if ($dataAcountLogin->rowCount() === 1) {
            $row = $dataAcountLogin->fetch();

            session_start(['name'=>'SPM']);

            $_SESSION['id_spm'] = $row['usuario_id'];
            $_SESSION['nombre_spm'] = $row['usuario_nombre'];
            $_SESSION['apellido_spm'] = $row['usuario_apellido'];
            $_SESSION['usuario_spm'] = $row['usuario_usuario'];
            $_SESSION['privilegio_spm'] = $row['usuario_privilegio'];
            $_SESSION['token_spm'] = md5(uniqid(mt_rand(),true));

            return header("Location: ".SERVERURL."/user-new/");
        } else {
            echo('<script>
                Swal.fire({
                    title: "Error",
                    text: "Las credenciales son incorrectas",
                    type: "error",
                    confirmButtonText: "Aceptar"
                })
            </script>');
        }
        
    }
}