<?php

class ViewsModels
{
    /*---------- Modelo para obtener las vistas -----------*/

    protected static function getViewsModel($vistas)
    {
        $listaBlanca = ["home","client-list","client-new","client-search","client-update","company","home","item-list","item-new","item-search","item-update","reservation-list","reservation-new","reservation-pending","reservation-reservation","reservation-search","reservation-update","user-list","user-new","user-search","user-update"];
        if (in_array($vistas, $listaBlanca)) {
            if (is_file("./Views/contents/".$vistas."-view.php")) {
                $contenido = "./Views/contents/".$vistas."-view.php";
                // $contenido = "./Views/contents/$vistas-view.php";
            }else{
                $contenido = "404";
            }
        }elseif($vistas=='login' || $vistas=='index'){
            $contenido = "login";
        }else{
            $contenido = "404";
        }

        return $contenido;
    }
}