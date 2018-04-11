<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11/04/2018
 * Time: 11:08 AM
 */


function setTel($id,$numero){

    $db = new MYSQL();

    $consultaTelefonos = $db->Consulta("INSERT INTO tel_numero (id,numero) VALUES (".$id.",".$numero.")");

    return json_encode($consultaTelefonos);
}