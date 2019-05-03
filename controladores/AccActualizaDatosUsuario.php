<?php

include ("../lib/db.php");
include ("../clases/Usuario.php");
include ("../lib/constantes.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!isset($_SESSION["Usuario"])){
    header("location:".URLBASE);
    exit;
}

$oUsr=$_SESSION["Usuario"];

if (!is_dir(DIRBASE."/img/usuario/")){
if(!mkdir(DIRBASE."/img/usuario/", 0777, true)) {
    die('Fallo al crear las carpetas...');
}
}
$idusuario=$oUsr->getId();
$upd=0;

if (isset($_FILES["imgusuario"]) &&$_FILES["imgusuario"]["name"]!="" ){
/*obtener extensión*/
$arrfile=pathinfo($_FILES["imgusuario"]["name"]);

/*Construcción nombre archivo*/
$sArchivo=$idusuario.".".$arrfile["extension"];
$sDirArchivo=DIRBASE."/img/usuario/".$sArchivo;
 

/*Nombre original*/
$sNomArchivo=$_FILES["imgusuario"]["name"];

/*Cambio de ubicación archivo temporal*/
move_uploaded_file($_FILES["imgusuario"]["tmp_name"], $sDirArchivo);


/*Actualización en la BBDD*/
$oUsr->setNomarchivo($sNomArchivo);
$oUsr->setArchivo($idusuario.".".$arrfile["extension"]);
$upd++;
}

if ($_POST["nombre"]!=$oUsr->getNombre()){
$oUsr->setNombre($_POST["nombre"]);
$upd++;
}

if ($_POST["clave2"]!=""){
   $oUsr->setClave($_POST["clave2"]);
$upd++;
}

var_dump($upd);
        
if ($upd>=1) $oUsr->ActualizaDatos();