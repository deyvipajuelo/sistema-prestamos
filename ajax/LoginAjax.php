<?php

$peticionAjax = true;
// require_once '../config/APP.php';

if (isset($_POST['user']) && isset($_POST['password'])) {
    
}else {
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header('Location: '.SERVERURL.'login/');
    exit();
}