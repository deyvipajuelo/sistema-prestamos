<?php

$peticionAjax = true;
// require_once '../config/APP.php';

if (isset($_POST['usuario_dni_reg'])) {

    /* ---------- Instanciar Controlador ---------- */
    require_once("../Controllers/UserController.php");
    $newUser = new UserController();
    
    /* ---------- Add new user ---------- */
    if (isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])) {
        echo($newUser->addUserController());
    }

}else {
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header('Location: '.SERVERURL.'login/');
    exit();
}