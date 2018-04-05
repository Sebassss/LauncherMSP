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


/*
http://10.64.65.200:84/otrs/nph-genericinterface.pl/Webservice/bott/Ticket?
UserLogin=LauncherMSP&Password=123456

{"Ticket":
 {
  "QueueID":"38",
  "PriorityID":"3",
  "CustomerUser":"MSP_COMPRAS",
  "Title":"REST Create Test",
  "StateID":"1",
  "Type":"Otro"},
 "Article":{"ContentType":"text/plain; charset=utf8","Subject":"Rest Create Test","Body":"This is
only a test"}
}
*/