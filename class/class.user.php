<?php

/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09/01/2017
 * Time: 08:22 AM
 */

require_once "class.conexion.php";

class user
{

    public $id;
    public $user;
    public $name;

    function __construct($_id){

        $this->id = $_id;

    }

    function getData(){

        $db = new MySQL();

        if(isset($_SESSION['id'])) {

            $result = $db->consulta("SELECT USUARIO_ID, USUARIO_NOMBRE, USUARIO_MAIL FROM usuarios WHERE USUARIO_ID = " . $this->id);

            $row = $db->fetch_array($result);

            $this->user = $row['USUARIO_MAIL'];
            $this->name = $row['USUARIO_NOMBRE'];

        }



    }
}