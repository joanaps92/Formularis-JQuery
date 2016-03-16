$(document).ready(function () {
    mostraAutors();
    $("body").append("<div id='botons'><button id='ActivaEdicio' style='hiden'>Activar Edicio</button></div>");
    $("body").append("<div id='botons'><button id='DesactivaEdicio' style='hiden'>Desactivar Edicio</button></div>");
    desactivar_Edicio();
    $("#ocult").hide();

    $("#boto_afegir").click(function () {
        $("#boto_afegir").hide();
        $("#ocult").show();
        introduirAutors();
    });

    $("#inserirAutor").click(function () {
        insertarAutor();
    });

    $("#cancelaAutor").click(function () {
        $("#ocult").hide();
        $("#boto_afegir").show();
    });

    $("#guardaAutor").click(function () {
        afegirAutor();
    });


    $("#afegir_col").click(function () {
        afegirColeccio($("#col").val());
    });
    
    $("#guardarCanvis").click(function(){
        updateLlibre();
    });

//    $("button").click(function () {
//        borrarAutor($("#codi").val(), $(this).val());
//    });

    $("#col").autocomplete(
            {
                source: "autocomplete.php",
                minLength: 2
            }
    );

});

function updateLlibre() {
    var codi = $("#codi").val();
    var titol = $("#titol").val();
    var nEdicio = $("#nEdicio").val();
    var any = $("#any").val();
    var lloc = $("#lloc").val();
    var desc = $("#desc").val();
    var isbn = $("#isbn").val();
    var legal = $("#legal").val();
    var sig = $("#sig").val();
    var col = $("#col").val();
    var dep = $("#dep").val();
    var edi = $("#edi").val();
    var llen = $("#llen").val();
    $.ajax({
        url: "updateLlibre.php",
        type: "POST",
        data: {
            codi: codi,
            titol: titol,
            nEdicio: nEdicio,
            any: any,
            lloc: lloc,
            desc: desc,
            isbn: isbn,
            legal: legal,
            sig: sig,
            col: col,
            dep: dep,
            edi: edi,
            llen: llen
        },
        success: function () {
            alert("Llibre actualitzat");
            //
            //location.reload();
        },
        error: function () {
            alert("No s'ha pogut actualitzar");
        }
    });
}

function insertarAutor() {
    var autor = $("#selectAutors").val();
    var llibre = $("#codi").val();
    $.ajax({
        url: "insertarAutors.php",
        type: "POST",
        data: {
            llibre: llibre,
            autor: autor
        },
        success: function () {
            mostraAutors();
        }
    });
}

function introduirAutors() {
    $.ajax({
        url: "llistaAutors.php",
        type: "POST",
        success: function (resposta) {
            var index = 0;
            for (var key in resposta) {
                $("<option>").attr("id", "aut" + index).val(resposta[key].ID_AUT).text(resposta[key].NOM_AUT).appendTo($("#selectAutors"));
                index++;
            }
            insertarAutor();
        },
        error: function () {

        }
    });
}

function afegirAutor() {
    var nom = $("#nom").val();
    var nacio = $("#nacionalitat").val();
    var naix = $("#naixament").val();

    $.ajax({
        url: "afegirAutor.php",
        type: "POST",
        data: {
            nouNom: nom,
            novaNacionalitat: nacio,
            nouNaixament: naix
        },
        success: function () {
            alert("AFEGIT");
            mostraAutors();
        },
        error: function () {
            ALERT("MALAMENT");
        }
    });
}

function borrarAutor(llibre, autor) {
    $.ajax({
        url: "borrarAutor.php",
        type: "POST",
        data: {
            llibre: llibre,
            autor: autor
        },
        success: function () {
            alert("DELETE FROM LLI_AUT WHERE FK_IDLLIB = " + llibre + " AND FK_IDAUT = " + autor);
            mostraAutors();
            activar_Edicio();
        },
        error: function () {
            alert("No s'ha pogut borratr l'autor amb id " + autor + " del llibre amb id " + llibre);
        }
    });
}
function afegirColeccio(coleccio) {

    $.ajax({
        url: "novaColeccio.php",
        type: "GET",
        data: {
            nom: coleccio
        },
        success: function () {
            alert("AFEGIDA " + coleccio);
        },
        error: function () {
            alert("NO AFEGIDA " + coleccio);
        }
    });
}
function mostraAutors() {
    netetjaAutors();
    var codi = $("#codi").val();
    $.ajax({
        url: "mostraAutors.php",
        type: "POST",
        data: {id: codi},
        success: function (resposta) {
            var i = 0;

            for (var key in resposta) {
                var id = resposta[key].ID_AUT;
                var nom = resposta[key].NOM_AUT;
                var taula = $("#taula_autors");
                $('<tr>').attr("id", "tr_" + i).appendTo(taula).attr("class", "autor");
                $('<td>').text(id).appendTo('#tr_' + i);
                $('<td>').text(nom).appendTo('#tr_' + i);
                $('<td>').attr("id", "BorrarAutor_" + i).appendTo('#tr_' + i);
                $('<button>').text("Borrar").attr("type", "button").attr("id", resposta[key].ID_AUT).appendTo("#BorrarAutor_" + i).attr("class", "botoBorrar").val(resposta[key].ID_AUT).bind("click", function () {
                    borrarAutor($("#codi").val(), $(this).val());
                });
                i++;
            }
//            $('<tr>').attr("id", "BotonsAutor").attr("class", "ocult autor").appendTo(taula);
//            $('<td>').attr("id", "GuardaAutor").appendTo("#BotonsAutor");
//            $('<button>').text("Guardar").attr("type", "button").attr("id", "GuardarButton").appendTo("#GuardaAutor");
//            $('<td>').attr("id", "CancelaAutor").appendTo("#BotonsAutor");
//            $('<button>').text("Cancelar").attr("type", "button").attr("id", "CancelaButton").appendTo("#CancelaAutor");
        },
        error: function () {

        }
    });
}
function desactivar_Edicio() {
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $("textarea").prop('disabled', true);
    $("button").prop('disabled', true);
    $("#ActivaEdicio").show().prop('disabled', false);
    $("#DesactivaEdicio").hide();
    $("#ActivaEdicio").click(activar_Edicio);

}

function activar_Edicio() {
    $("input").prop('disabled', false);
    $("select").prop('disabled', false);
    $("textarea").prop('disabled', false);
    $("button").prop('disabled', false);
    $("#DesactivaEdicio").show();
    $("#ActivaEdicio").hide();
    $("#DesactivaEdicio").click(desactivar_Edicio);
}

function validar() {
//Comprobación de inputs vacios y input numérico
    if ($("input[name='titol']").val().length < 1 || $("input[name='anyedicio']").val().length < 1) {
        alert("El camp titol i any d'edicio són obligatoris");
        return false;
    }
    if (isNaN($("input[name='anyedicio']").val())) {
        alert("L'any d'edicio ha de ser una número");
        return false;
    }
    return true;
}

function netetjaAutors() {
    $(".autor").remove();
}