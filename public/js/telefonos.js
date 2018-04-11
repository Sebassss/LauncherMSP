/**
 * Created by Ivan on 11/04/2018.
 */

var telefonos = [];

var lugares = [];

$(function(){

    $.ajax({
        url: 'gettel',
        dataType: 'json',
        success: function(data){
            telefonos = data;
        }

    }).done(function(){
        fillTable();
    });

    $("#btnNuevo").click(function(){

        $.ajax({
            url: 'getlugares',
            dataType: 'json',
            success: function(data){

                console.log(data)
                var htmlString =
                    '<label for="lugar">Lugar</label>' +
                    '<select id="lugar">';

                for(var index in data){

                    htmlString +=
                        '<option value="' + data[index]['id'] + '">'+ data[index]['lugar'] +'</option>'

                }

                htmlString += '</select>';

                htmlString +=
                    '     <input id="nuevoNumero" type="number" placeholder="nuevo número" >';

                $(".modal-title").text("Nuevo número de teléfono");

                $(".modal-body")
                    .empty()
                    .append(htmlString);

                $("#modal").modal('show');

                $("#aceptar")
                    .unbind('click')
                    .click(function(){

                    var idlugar = $("#lugar").val();
                    var numero = $("#nuevoNumero").val();


                    $.ajax({
                        url: 'gettel',
                        type: 'POST',
                        data: {
                            'id': idlugar,
                            'numero': numero
                        },
                        dataType: 'json',
                        success: function(data){
                            console.log(data);
                            console.log("se agrega el número " + numero + " al lugar " + idlugar);
                            updateTable();
                        }

                    });



                });
            }
        });
    });

});
/*
function fillSearch(){


    console.log(telefonos)

    $('#telefonos').select2({
        data: telefonos
    });
}*/

function updateTable(){

    $.ajax({
        url: 'gettel',
        dataType: 'json',
        success: function(data){
            telefonos = data;
        }

    }).done(function(){
        fillTable();
    });
}

function fillTable() {

    var htmlString = '';

    telefonos.forEach(function(element){
        htmlString +=
            '<tr>' +
            '   <td>'+ element['lugar'] +'</td>' +
            '   <td>'+ element['numero'] +'</td>' +
            '</tr>';
    });

    $("#telefonosbody")
        .empty()
        .append(htmlString)


}