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

class Menu extends MySQL
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Funcion que retorna los permisos de un recurso como menu
     *
     * @param int $usuario_id
     * @param int $recurso_id
     * @return object|stdClass
     */



    function display_children($parent, $level, $user)
    {


        $sql = "SELECT a.menu_id, a.menu_titulo,a.menu_icon, a.menu_link, Deriv1.Count as Count FROM menu a
                     LEFT OUTER JOIN (SELECT menu_parent, COUNT(*) AS Count FROM menu GROUP BY menu_parent) Deriv1 ON a.menu_id = Deriv1.menu_parent
                     LEFT JOIN menuperfil pr on pr.menu_id= a.menu_id
                     LEFT JOIN usuarioperfil up on up.perfil_id= pr.perfil_id
                     WHERE a.menu_parent = ".$parent." and up.usuario_id = ".$user." group by a.menu_id,a.menu_titulo, a.menu_icon,a.menu_link, Deriv1.count order by menu_orden asc";

/*
        $sql = "SELECT m.menu_id, m.menu_titulo, m.menu_link,Deriv1.menu_parent, Deriv1.Count, m.menu_icon FROM menu m
						   LEFT JOIN (SELECT menu_parent, COUNT(*) AS Count FROM menu GROUP BY menu_parent) 
						   Deriv1 ON m.menu_id = Deriv1.menu_parent 
						   where m.menu_parent =" . $parent . " group by m.menu_id order by m.menu_orden";

*/
        $result = $this->Consulta($sql);

        if ($this->num_rows($result) > 0)
        {

            while ($resultados = $this->fetch_array($result))
            {

                    if($resultados['Count'] >0)
                    {
                        echo '<li class="dropdown">
                            <a href="'.$resultados['menu_link'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$resultados['menu_icon'].'&nbsp;&nbsp;&nbsp;'.$resultados['menu_titulo'].' <span class="caret"></span></a>
                            <ul class="dropdown-menu">';
                            $menu = new Menu();
                            $menu->display_children($resultados['menu_id'], $level + 1, $user);
                        echo '</ul></li>';
                    }
                    else if($resultados['Count'] ==0){
                        echo '<li><a href="'.$resultados['menu_link'].'">'.$resultados['menu_icon'].'&nbsp;&nbsp;'.$resultados['menu_titulo']. '</a></li>'; //'<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    }
                    else;


            }
        }

    }



}