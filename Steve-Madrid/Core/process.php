<?php

$host_aceptados = array('localhost', '127.0.0.1');
$metodo_aceptado = 'POST';
$usuario_correcto = "Admin";
$password_correcto = "Admin";

$txt_usuario = $_POST["txt_usuario"];
$txt_password = $_POST["txt_password"];
$token = "";

if(in_array($_SERVER["HTTP_HOST"],$host_aceptados) ){
    //La direccion ip es aceptada
    if($_SERVER["REQUEST_METHOD"] == $metodo_aceptado){
        //se acepta el metodo usado por el usuario
        if(isset($txt_usuario) && !empty($txt_usuario)){
            //Si se enviaron valores en el cmpo usuario
            if(isset($txt_password) && !empty($txt_password)){
                //Si se envio el valor de la contrasena
                if($txt_usuario == $usuario_correcto){
                    //El valor ingresado del campo usuario es correcto
                    if($txt_password==$password_correcto){
                        //El valor ingresado del campo contrasena es correcto
                        $ruta = "welcome.php";
                        $msg = "";
                        $codigo_estado = 200;
                        $texto_estado = "Ok";
                        list($usec,$sec) = explode(' ',microtime());
                        $token = base64_encode(date("Y-m-d H:i:s",$sec).substr($user,1));
                    }else{
                        //El valor ingresado del campo password no es correcto
                        $ruta = "";
                        $msg = "SU CONTRASENA ES INCORRECTA";
                        $codigo_estado = 400;
                        $texto_estado = "Bad Request";
                        $token = "";
                    }
                }else{
                    //El valor ingresado del campo usuario no es correcto
                        $ruta = "";
                        $msg = "NO SE RECONOCE EL USUARIO DiGITADO";
                        $codigo_estado = 401;
                        $texto_estado = "Unauthorized";
                        $token = "";
                }
            }else{
                //El campo password esta vacío
                        $ruta = "";
                        $msg = "El CAMPO DE CONTRASENA ESTA VACIO";
                        $codigo_estado = 401;
                        $texto_estado = "Unauthorized";
                        $token = "";
            }            
        }else{
            //El campo usuario eta vacío
                        $ruta = "";
                        $msg = "SU CONTRASENA ES INCORRECTA";
                        $codigo_estado = 401;
                        $texto_estado = "Unauthorized";
                        $token = "";
        }
    }else{
        //El valor ingresado del campo usuario no es aceptado
                    $ruta = "";
                        $msg = "EL CAMPO DE CONTRASENA ESTA VACIO";
                        $codigo_estado = 405;
                        $texto_estado = "Method not allowed";
                        $token = "";
    }
}else{
    //La dirección IP no es acceptada
                        $ruta = "";
                        $msg = "SU EQUIPO NO ESTA AUTORIZDO PARA REALIZAR ESTA PETICION";
                        $codigo_estado = 403;
                        $texto_estado = "Forbidden";
                        $token = "";
}
 $arreglo_respuesta = array(
                "status" => (   (intval($codigo_estado) == 200) ? "Ok": "Error"),
                "error" => (    (intval($codigo_estado) == 200) ? "" : array("code"=>$codigo_estado, "message"=>$msg) ),
                "data" => array(
                    "url"=>$ruta,
                    "token" =>$token
                ),
                "count"=>1
            );
            
            header("HTTP/1.1 ".$codigo_estado." ".$texto_estado);
            header("Content-Type: Application/json");
            echo(json_encode($arreglo_respuesta));

?>