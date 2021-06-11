<?php

require_once("./Models/ViewsModel.php");

class ViewsControllers extends ViewsModels
{
    /*----------------- Controlador para obtener la plantilla ------------------- */

    public function getTemplateController()
    {
        return require_once('./Views/template.php');
    }

    public function getViewsController()
    {
        if (isset($_GET['views'])) {
            $ruta = explode('/', $_GET['views']);
            $respuesta = ViewsModels::getViewsModel($ruta[0]);
        }else{
            $respuesta = 'login';
        }
        
        return $respuesta;
    }
}