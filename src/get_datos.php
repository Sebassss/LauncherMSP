<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 05/04/2018
 * Time: 08:13 AM
 */

require_once  "../class/class.conexion.php";



function getData(){

    $db = new MYSQL();

    $consultaCustomers = $db->Consulta("SELECT login as customer FROM customer_user");


/*
    $consulta = $db->Consulta("select t.tn as NTicket, \n".
        "		   date_format(t.create_time,'%d/%m/%Y %H:%i:%s') as Fecha_Hora,\n".
        "			 ta.a_subject as Asunto, \n".
        "			 ta.a_body as Detalle, \n".
        "			 ta.a_from as Cliente from ticket t \n".
        "	inner join article ta on t.id = ta.ticket_id\n".
        "	inner join ticket_flag tf on tf.ticket_id = t.id\n".
        "	inner join ticket_state ts on ts.id = t.ticket_state_id\n".
        "where (ts.`name` = 'Nuevo' or ts.`name` = 'Abierto.') and  \n".
        "			 date_format(t.create_time, '%Y') = date_format(DATE(NOW()),'%Y') AND\n".
        "			 t.queue_id < 19 or t.queue_id > 37");*/

    $x=0;
    $customers=  array();

    while($row = $db->fetch_array($consultaCustomers))
    {
        $customers[$x] = $row['customer'];
        $x++;
    }

    $consultaTipos = $db->Consulta("select name as tipo from ticket_type");

    $x=0;
    $tipos =  array();

    while($row = $db->fetch_array($consultaTipos))
    {
        $tipos[$x] = $row['tipo'];
        $x++;
    }

    return json_encode(array(
        'customers' => $customers,
        'tipo' => $tipos
    ));
}



function getTickets(){

    $db = new MYSQL();



    $consulta = $db->Consulta( "select t.tn as nticket,".
        "							 tp.name as prioridad,".
        "        		   date_format(t.create_time,'%d/%m/%Y %H:%i:%s') as fechahora,".
        "							 (select ta.a_from from article ta where ta.ticket_id = t.id limit 0,1) as oficina, ".
        "							 (select ta.a_subject from article ta where ta.ticket_id = t.id limit 0,1) as motivo,".
        "							 (select ta.a_body from article ta where ta.ticket_id = t.id limit 0,1) as detalle".
        "        			  from ticket t ".
        "        	inner join ticket_state ts on ts.id = t.ticket_state_id".
        "			    inner join ticket_priority tp on tp.id = t.ticket_priority_id".
        "        where (ts.name = 'Nuevo' or ts.name = 'Abierto.') and  ".
        "        			 date_format(t.create_time, '%Y') = date_format(DATE(NOW()),'%Y') AND".
        "        			 t.queue_id < 19 or t.queue_id > 37 order by t.create_time, t.ticket_priority_id ");

    $x=0;
    $result=  array();

    while($row = $db->fetch_array($consulta))
    {
        $result[$x] = $row;
        $x++;
    }


    return json_encode($result);
}

function getTel(){

    $db = new MYSQL();

    $consultaTelefonos = $db->Consulta("SELECT lugar, numero FROM tel_lugar tl JOIN tel_numero tn on tn.id = tl.id");

    $x=0;
    $telefonos=  array();

    while($row = $db->fetch_array($consultaTelefonos))
    {
        $telefonos[$x] = array(
            'lugar' => $row['lugar'],
            'numero' => $row['numero']
        );
        $x++;
    }


    return json_encode($telefonos);
}


function getLugares(){

    $db = new MYSQL();

    $consultaLugares = $db->Consulta("SELECT id, lugar FROM tel_lugar");

    $x=0;
    $lugares=  array();

    while($row = $db->fetch_array($consultaLugares))
    {
        $lugares[$x] =
            array(
                'id' => $row['id'],
                'lugar' => $row['lugar']
            );
        $x++;
    }


    return json_encode($lugares);
}
