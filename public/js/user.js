/**
 * Created by Ivan on 03/04/2018.
 */
var axx = [];
//texto para botón de GeDoc
axx.gedoc =
    {
        title: "Sistema de Gestión de Documentos",
        body: "A continuación usted va a ingresar a GeDoc",
        url: "http://10.64.65.200/gedoc"

    };

axx.siged =
    {
        title: "SiGeD",
        body: "Este Sistema debe ser abierto desde Internet Explorer.",
        url: "http://10.64.65.200/gedoc"
    };

axx.mesadeentrada =
    {
        title: "Mesa de Entrada",
        body: "Este Sistema debe ser abierto desde Internet Explorer.",
        url: "http://10.64.65.200/sistema"
    };

axx.nutricion =
    {
        title: "Nutrición",
        body: "Sistema de la división Nutricion.",
        url: "http://10.64.65.200:81/nutricion/"
    };

axx.regprof =
    {
        title: "Registro de profesionales",
        body: "Sistema de Registro de Profesionales.",
        url: "http://10.64.65.200/srproftest/"
    };

axx.otrs =
    {
        title: "O.T.R.S.",
        body: "Sistema de gestión de Incidentes.",
        url: "http://10.64.65.200:84/otrs/"
    };

axx.permisosinternet =
    {
        title: "Solicitud de permisos especiales de internet",
        body: "Complete el formulario a continuacíon.",
        url: "http://10.2.0.1/formulario/pdf/01-Permisos.pdf"
    };
axx.email =
    {
        title: "Email oficial",
        body: "Ingreso al correo oficial de Salud Pública.",
        url: "https://webmail.sanjuan.gov.ar/owa/auth/logon.aspx?url=https://webmail.sanjuan.gov.ar/owa/&reason=0"
    };


var noticias = [];

//contador de noticias
var contadorNoticias = 0;
//intervalo de cambio de noticia
//var intervalo = setInterval(proximaNoticia, 8000);

//animate.css
$.fn.extend({
    animateCss: function(animationName, callback) {
        var animationEnd = (function(el) {
            var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
            };

            for (var t in animations) {
                if (el.style[t] !== undefined) {
                    return animations[t];
                }
            }
        })(document.createElement('div'));

        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);

            if (typeof callback === 'function') callback();
        });

        return this;
    },
});

var customers;
var tipo;

//busca valores iniciales de los selectores
$.ajax({
    url: 'getdata',
    dataType: 'json',
    success: function(data){

        customers = data.customers;
        tipo = data.tipo;


    }

}).done(function(){
    fillSelects();
});

function fillSelects(){

    customers.unshift('Seleccione una opción...');

    //console.dir(customers)
    $('#customer').select2({
        data: customers
    });

    tipo.unshift('Seleccione una opción...');
    $('#tipo').select2({
        data: tipo
    });

}

$(function(){

    // Opera 8.0+
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';

    // Safari 3.0+ "[object HTMLElementConstructor]"
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;

    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;

    // Chrome 1+
    var isChrome = !!window.chrome && !!window.chrome.webstore;

    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;

    if(isIE) $(".formulario").hide();

    $("#enviar").click(function(){
        verificar();
    });

    $(".axx").click(function(){

        //$("#detailModal").modal('show');
        openModal($(this));
    });

    //agregar a favoritos
    $("#book").click(function(){
        AddToFavorite("gedoc.com","El sistema de turnos caídos");
    });

    $(document).ready(function(){

        getLauncher();

        setInterval(function(){
            getLauncher()
        },25000)
    });

});


function verificar(){

    var flag = true;
    var error = [];

    if( $("#nombre").val() === "" ) {
        flag = false;
        error.push('Nombre completo');
    }

    if( $("#telefono").val() === "" ){
        flag = false;
        error.push("Teléfono interno o personal");
    }

    if($("#customer").select2('data')[0].text === "Seleccione una opción..."){
        flag = false;
        error.push("Lugar desde donde hace el reclamo");
    }

    if($("#tipo").select2('data')[0].text === "Seleccione una opción..."){
        flag = false;
        error.push("Tipo de problema a reportar");
    }

    if($("#comentario").val() === ""){
        flag = false;
        error.push("Comentario");
    }

    if(!flag){

        $(".modal-title")
            .empty()
            .append("Por favor, complete correctamente los siguientes campos:");

        var htmlString = '<ul>';

        error.forEach(function(element){

            htmlString +=
                '<li>' +
                element +
                '</li>';
        });

        htmlString += '</ul>';

        $(".modal-body")
            .empty()
            .append(htmlString);

        $("#detailModal").modal('show');

    }else{

        enviarTicket()
    }

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
//envío de tickets
function enviarTicket(){
/*
    var data2send =
        {"Ticket": {
            "QueueID": "38",
            "PriorityID": "3",
            "CustomerUser": $("#customer").select2("data")[0].text,
            "Title": "Mensaje desde launcher de: " + $("#nombre").val(),
            "StateID": "1",
            "Type": $("#tipo").select2("data")[0].text
        },"Article":
                    {"ContentType":"text/plain; charset=utf8",
                     "Subject": "Reclamo desde Launcher - Teléfono: " + $("#telefono").val(),
                     "Body": $("#comentario").val()
                    }
            };
*/
    //console.dir(data2send)

    var data2send = {};

    data2send.CustomerUser = $("#customer").select2("data")[0].text;

    data2send.Type = $("#tipo").select2("data")[0].text;

    data2send.Title = "Ticket desde Launcher solicitado por: " + $("#nombre").val();

    data2send.Body = " -- " + $("#comentario").val();

    data2send.Subject = "Contacto: " + $("#telefono").val();

    $.ajax({
        //url: 'http://10.64.65.200:84/otrs/nph-genericinterface.pl/Webservice/bott/Ticket?UserLogin=LauncherMSP&Password=123456',
        url: 'sendticket',
        contentType: 'application/json',
        type: 'GET',
        dataType: 'json',
        data: {
            customer: data2send.CustomerUser,
            type: data2send.Type,
            title: data2send.Title,
            body: data2send.Body,
            subject: data2send.Subject
        },
        beforeSend: function(){

            $(".modal-title")
                .empty()
                .append('Espere un momento por favor..');

            $(".modal-body")
                .empty()
                .append('Se está creando su solicitud...');

            $(".btnmodal").hide();

            $("#detailModal")
                .modal('show');
        },
        success: function(data){

            //console.log(data);

            $(".modal-title")
                .empty()
                .append('Ticket creado correctamente.');

            $(".modal-body")
                .empty()
                .append('Anote el número de su ticket: <b>' + data.TicketNumber + '</b>');

            $(".btnmodal").show();

        },
        error: function(e){
            console.log("Error en el acceso a la base de datos");
            console.log(e);
        },
        timeout: 12000

    });
}





function getLauncher()
{
    $.ajax({
        url: 'getLauncherNews',
        dataType: 'json',
        success: function(data) {
            //alert('done');
            noticias = [];

            for (var i = 0; i < data.length; i++) {

                //$("#titulonoticia").text(data[i].titulo);
                //$("#textonoticia").text(data[i].detalle);
               noticias.push({"titulo" : data[i].titulo, "texto" : data[i].detalle })
            }


            //console.dir(noticias);





            $("#noticias").animateCss('fadeOutUp',function () {
                //console.log("aca")
                //console.dir(noticias);
                if(noticias[contadorNoticias] !='undefined') {
                    $("#titulonoticia").text(noticias[contadorNoticias].titulo);
                    $("#textonoticia").text(noticias[contadorNoticias].texto);
                }
                $("#noticias").animateCss('fadeInDown', function () {
                    contadorNoticias++;
                });

            });
            if(contadorNoticias === noticias.length) contadorNoticias = 0;






        },
        error: function(e) {
            console.log(e.responseText);
        }
    });
}
//https://helloacm.com/add-to-favorite-using-javascript/
var AddToFavorite = function(url, title) {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("msie 8") > -1) {
        external.AddToFavoritesBar(url, title, '');
    } else {
        try {
            window.external.addFavorite(url, title);
        } catch (e) {
            try {
                window.sidebar.addPanel(title, url, '');
            } catch (e) {
                alert("Por favor, presione Ctrl+D para agregar a favoritos");
            }
        }
    }
    return false;
};

function openModal(selector){

    var data = axx[selector.data('nombre')];

    $(".modal-title")
        .empty()
        .append(data.title);

    $(".modal-body")
        .empty()
        .append(data.body);

    $(".ir")
        .text('Ingresar')
        .unbind('click')
        .click(function(){
        window.open(data.url,'_blank');
    });

    $("#detailModal").modal('show');
}
