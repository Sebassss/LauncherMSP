 <?php
/**
 * Clase de conexiòn
 *
 * Clase para gestionar la conexion a la base de datos
 *
 * @category   Configuracion
 * @package    base de datos
 * @copyright  Copyright (c) 2016 pseba20@gmail.com
 * @version    $Id:$
 */

require  "db.inc.php";
class MySQL {

   private $conexion;
   private $consulta;


    /**
    * Contructor que inicia la conexion
    */
    public function __construct (){
       $this->conexion = mysqli_connect (DATABASE_HOST,DATABASE_USER,DATABASE_PASS);
       mysqli_set_charset($this->conexion,"utf8");
       mysqli_select_db($this->conexion,DATABASE_NAME);
   }

    /**
    * funcion que ejecuta una consulta sql
    * @param $Sql
    */
    public function Consulta($sql){
       $this->consulta =  mysqli_query($this->conexion,$sql);
        return mysqli_error($this->conexion);
    }

    /**
    * funcion que retorna el resultado de una consulta en objetos
    */
    public function obtenerObjeto(){
        $i = mysqli_num_rows($this->consulta); //Verifico si la query ha devuelto resultados
        if($i>0) {
            return mysqli_fetch_object($this->consulta);
        }
        else{
            /*Creo un objeto vacio para devolver*/
            $obj = new stdClass();
            $obj->consultar=0;
            $obj->agregar=0;
            $obj->editar=0;
            $obj->eliminar=0;
            return $obj;
        }
    }

    /**
    * Funcion que finaliza la conexion a la base de datos
    */
    public function desconectar () {
        mysqli_close($this->conexion);
    }

    public function num_rows($consulta){
        return mysqli_num_rows($this->consulta);
    }

     public function fetch_array($consulta){

         return mysqli_fetch_array($this->consulta);
     }
 }