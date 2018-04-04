/**
 * Created by Ivan on 03/04/2018.
 */
var axx = [];
//texto para botón de GeDoc
axx.gedoc =
    {
        title: "Sistema de Gestión de Documentos",
        body: "El sistema GeDoc le permite tirar turnos con solamente un par de clicks",
        url: "http://10.64.65.200/gedoc"

};


$(function(){

    $(".axx").click(function(){

        //$("#detailModal").modal('show');
        openModal($(this));
    });
});



function openModal(selector){

    var data = axx[selector.data('nombre')];

    $(".modal-title")
        .empty()
        .append(data.title);

    $(".modal-body")
        .empty()
        .append(data.body);

    $(".ir").click(function(){
        window.open(data.url,'_blank');
    });

    $("#detailModal").modal('show');
}

