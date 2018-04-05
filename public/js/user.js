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

axx.siged =
    {
        title: "SiGeD",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };

axx.mesadeentrada =
    {
        title: "Mesa de Entrada",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };

axx.nutricion =
    {
        title: "Nutrición",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };

axx.regprof =
    {
        title: "Registro de profesionales",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };

axx.otrs =
    {
        title: "O.T.R.S.",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };

axx.permisosinternet =
    {
        title: "Solicitud de permisos especiales de internet",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };
axx.gmail =
    {
        title: "Gmail",
        body: "explicación",
        url: "http://10.64.65.200/gedoc"
    };


const noticias = [
    {
        titulo: "Primer título",
        texto: "primer texto de prueba",
        url: "google.com"
    },
    {
        titulo: "Segundo título",
        texto: "segundo texto"
    }
];

//contador de noticias
var contadorNoticias = 0;
//intervalo de cambio de noticia
var intervalo = setInterval(proximaNoticia, 8000);

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

$.ajax({
    url: 'getdata',
    dataType: 'json',
    success: function(data){

        customers = data.customers;
        tipo = data.tipo;

        fillSelects();
    }

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

    $("#enviar").submit(function(){

        console.log("hola carola");
    });

    $(".axx").click(function(){

        //$("#detailModal").modal('show');
        openModal($(this));
    });

    //agregar a favoritos
    $("#book").click(function(){
        AddToFavorite("gedoc.com","El sistema de turnos caídos");
    });

});

//carga de noticias
function proximaNoticia(){

    $("#noticias").animateCss('fadeOutUp',function () {

        $("#titulonoticia").text(noticias[contadorNoticias].titulo);
        $("#textonoticia").text(noticias[contadorNoticias].texto);

        $("#noticias").animateCss('fadeInDown', function () {

        });

    });


    contadorNoticias ++;

    if(contadorNoticias === noticias.length) contadorNoticias = 0;

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

    $(".ir").click(function(){
        window.open(data.url,'_blank');
    });

    $("#detailModal").modal('show');
}
