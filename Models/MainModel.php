<?php

if($peticionAjax){
    require_once('../config/SERVER.php');
}else {
    require_once('./config/SERVER.php');
}

class MainModel
{
    /* ---------- Función conectar a BD ---------- */
    protected static function connect()
    {
        $conection = new PDO(SGBD, USER, PASS);
        $conection->exec('SET CHARACTER SET utf8');
        return $conection;
    }

    /* ---------- Función ejecutar consultas simples ---------- */
    protected static function runSimpleQuery($query)
    {
        $sql = self::connect()->prepare($query)->execute();
        return $sql;
    }
    
    /* ---------- Función Encriptar String ---------- */
    public function encryption($string)
    {
        // $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

    /* ---------- Función Desencriptar String ---------- */
    protected static function decryption($string)
    {
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    /* ---------- Función Generar Códigos Aleatorios ---------- */
    protected static function generateRandomCodes($letter, $length, $number)
    {
        /* Se generarán este tipo de códigos: P876-1 */
        for ($i=0; $i < $length ; $i++) { 
            $aleatorio = rand(0,9);
            $letter .= $aleatorio;
        }
        return "$letter - $number";
    }

    /* ---------- Función LImpiar Cadenas ---------- */
    protected static function cleanString($string)
    {
        /* -- Eliminar espacios --*/
        $string = trim($string);
        /* -- Eliminar barras invertidas '\' --*/
        $string = stripslashes($string);
        /* -- Eliminar cadenas maliciosas --*/
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src", "", $string);
        $string = str_ireplace("<script type=", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("DROP TABLE", "", $string);
        $string = str_ireplace("DROP DATABASE", "", $string);
        $string = str_ireplace("TRUNCATE TABLE", "", $string);
        $string = str_ireplace("SHOW TABLES", "", $string);
        $string = str_ireplace("SHOW DATABASES", "", $string);
        $string = str_ireplace("<?php", "", $string);
        $string = str_ireplace("?>", "", $string);
        $string = str_ireplace("--", "", $string);
        $string = str_ireplace(">", "", $string);
        $string = str_ireplace("<", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("]", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("==", "", $string);
        $string = str_ireplace(";", "", $string);
        $string = str_ireplace("::", "", $string);
        /* -- Eliminar barras invertidas '\' --*/
        $string = stripslashes($string);
        /* -- Eliminar espacios --*/
        $string = trim($string);

        return $string;
    }

    /* ---------- Función LImpiar Cadenas ---------- */
    protected static function verifyData($filter, $string)
    {
        if (preg_match('/^'.$filter.'$/', $string)) {
            return false;
        }else {
            return true;
        }
    }
    
    /* ---------- Función Verificar Fechas ---------- */
    protected static function verifyDate($date)
    {
        $valores = explode('-',$date);
        if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
            return false;
        }else{
            return true;
        }
    }
    
    /* ---------- Función paginar tablas ---------- */
    protected static function paginateTable($page, $numPages, $url, $numButtons)
    {
        $paginate = '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';

        if ($page == 1) {
            $paginate .= '<li class="page-item disabled">
                            <a class="page-link"><i class="fas fa-angle-left"></i></a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>';
        }else {
            $paginate .= '<li class="page-item">
                            <a class="page-link" href="'.$url.'1/">Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="'.$url.($page-1).'"><i class="fas fa-angle-left"></i></a>
                        </li>';
        }

        /*----- Dibujar los botones del medio -----*/
        $ci = 0;
        for ($i=$page; $i < $numPages; $i++) { 
            if ($ci == $numButtons) {
                break;
            }

            if ($page == $id) {
                $paginate .= '<li class="page-item">
                                <a class="page-link active" href="'.$url.$i.'">'.$i.'</a>
                            </li>';
            }else {
                $paginate .= '<li class="page-item">
                                <a class="page-link" href="'.$url.$i.'">'.$i.'</a>
                            </li>';
            }
        }

        if ($page == $numPages) {
            $paginate .= '<li class="page-item disabled">
                            <a class="page-link">Next</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link"><i class="fas fa-angle-right"></i></a>
                        </li>';
        }else {
            $paginate .= '<li class="page-item">
                            <a class="page-link" href="'.$url.($page+1).'">Next</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="'.$url.$numPages.'"><i class="fas fa-angle-right"></i></a>
                        </li>';
        }

        $paginate .= '</ul></nav>';
        return $paginate;
    }
}