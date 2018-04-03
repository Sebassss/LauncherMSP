 <?php
/**
 * Clase Permiso
 *
 * Clase para validar los permiso de un usuario sobre un recurso del sistema
 *
 * @category   Configuracion
 * @package    base de datos
 * @copyright  Copyright (c) 2016 pseba20@gmail.com
 * @version    $Id:$
 */

class Permiso extends  MySQL {

    public function __construct (){
        parent::__construct();
    }


    /**
     * Funcion que retorna los permisos de un recurso
     *
     * @param int $usuario_id
     * @param int $recurso_id
     * @return object|stdClass
     */

    public function validarPermiso ($usuario_id = 0,$recurso_id=0){

        $sql = '
               /* VALIDO LAS ACCIONES DE UN USUARIO SOBRE UN RECURSO DEL SISTEMA */
               SELECT IF(SUM(Consultar) >= 1, 1,0) as consultar,
                       IF(SUM(Agregar) >= 1, 1,0) as agregar,
                       IF(SUM(Editar) >= 1, 1,0) as editar,
                       IF(SUM(Eliminar) >= 1, 1,0) as eliminar
                FROM Tbl_PerfilesRecursos
                WHERE RecursoID = '.(int)$recurso_id.'
                AND PerfilID IN (
                    /* SELECCIONO LOS PERFILES DEL USUARIO*/
                    SELECT PerfilID
                    FROM Tbl_UsuariosPerfiles
                    WHERE UsuarioID = '.(int)$usuario_id.'
                )
                GROUP BY RecursoID';

        $this->Consulta($sql);

        return  $this->obtenerObjeto();

    }

}