var DATA = [];
var DATA2 = [];
var validarArrayLLenos = [];

$("#enviar").click(function () {//BOTÓN GUARDAR

    if ($('#titulo').val() === "") {
        showAlert("La encuesta debe tener un título", "error", 250, 60);//VALIDA ARRAY PREGUNTAS QUE AL MENOS TENGA 1 VAlOR
        return;
    }

    if (DATA.length === 0) {
        showAlert("Debe ingresar al menos una pregunta", "error", 250, 60);//VALIDA ARRAY PREGUNTAS QUE AL MENOS TENGA 1 VAlOR
        return;
    }


    if (DATA2.length === 0) {
        showAlert("Las preguntas ingresadas no tienen respuesta", "error", 250, 60);//VALIDA ARRAY RESPUESTAS QUE AL MENOS TENGA 1 VAlOR
        return;
    }

    var campos = {'titulo': $('#titulo').val(), 'DATA': JSON.stringify(DATA), 'DATA2': JSON.stringify(DATA2)};

    $.ajax({
        data: campos,
        url: 'modelo/guardarEncuesta.php',
        type: 'post', //los datos van a traves de POST

        success: function (response) {
            console.log(response);
            if (response == 1) {
                window.location.href = "vis_administrador.php?mensaje=registro";

            } else {
                window.location.href = "vis_administrador.php?mensaje=errorEncuesta";
            }
        }
    });
});

//AGREGA PREGUNTA
var index = 0;
$('#new_pregunta').click(function () {

    if ($('#pregunta').val() !== "") {
        $('#tbl_preguntas').append('<tr id="' + index + '"><td id="td_id">' + $('#pregunta').val() + '</td><td><i class="fa fa-eraser" aria-hidden="true" data-toggle="tooltip" title="Eliminar Pregunta" onClick="removerPregunta(' + index + ',1)" style="color:blue;cursor:pointer"></i></td></tr>');
        index++;
        $('#pregunta').val("");//limpiar caja de texto de pregunta
        datosTablas(1);
    } else {
        showAlert("Debe existir una pregunta", "error", 250, 60);
    }

});

function removerPregunta(indice, opcion) {
    console.log(indice);

    if (opcion === 1) {
        $('#tbl_preguntas #' + indice).remove();
        datosTablas(1);
    } else {
        $('#tbl_respuestas #' + indice).remove();
        datosTablas(2);
    }
}

//AGREGA RESPUESTA
var indexR = 0;
$('#new_respuesta').click(function () {
    $('#tbl_respuestas').append('<tr id="' + indexR + '"><td id="td_id3">' + $('#selec_preguntas').val() + '</td><td id="td_id2">' + $('#respuesta').val() + '</td><td><i class="fa fa-eraser"  data-toggle="tooltip" title="Eliminar Respuesta" aria-hidden="true" onClick="removerPregunta(' + indexR + ',2)" style="color:blue;cursor:pointer"></i></td></tr>');
    indexR++;
    $('#selec_preguntas').val("");
    $(' #respuesta').val("");
    datosTablas(2);
});

function datosTablas(opc) {
    var TABLA;
    var valorTD;
    var valorTD2;

    //arreglo pregunta-respuesta
    if (opc === 1) {
        DATA = [];
        TABLA = $("#tbl_preguntas tbody > tr");
    } else {
        DATA2 = [];
        TABLA = $("#tbl_respuestas tbody > tr");

    }

    TABLA.each(function () {

        if (opc === 1) {
            valorTD = $(this).find("td[id='td_id']").text();
        } else {
            valorTD = $(this).find("td[id='td_id2']").text();
            valorTD2 = $(this).find("td[id='td_id3']").text();
        }

        item = {};

        if (valorTD !== '') {
            if (opc === 1) {
                item ["id"] = valorTD;
                DATA.push(item);
            } else {
                item ["pregunta"] = valorTD2;
                item ["respuesta"] = valorTD;
                DATA2.push(item);
            }
        }
    });

    if (opc === 1) {
        $('option', '#selec_preguntas').remove();//limpiar arreglo
        $('#selec_preguntas').append('<option value="" >seleccione Pregunta</option>');
        for (var i = 0; i < DATA.length; i++) {
            $('#selec_preguntas').append('<option value="' + DATA[i]['id'] + '" >' + DATA[i]['id'] + '</option>');
        }
    }

}

function showAlert(mensaje, cssClas, width, height) { //info,error,success
    if ($("#notificaciones").length === 0) {
        //creamos el div con id notificaciones
        var contenedor_notificaciones = $(window.document.createElement('div')).attr("id", "notificaciones");
        //a continuación la añadimos al body
        $('body').append(contenedor_notificaciones);
    }
    //llamamos al plugin y le pasamos las opciones
    $.notificaciones({
        mensaje: mensaje,
        width: width,
        cssClass: cssClas, //clase de la notificación
        timeout: 4000, //milisegundos
        fadeout: 1000, //tiempo en desaparecer
        radius: 5, //border-radius
        height: height

    });
}
//EDITAR CAMPOS DE RESPUESTA HACIENDO DOBLE CLIC
$(function () {
    var locacion = window.location.href;    
    var cadena = locacion.toString().split("/");
    if (cadena[cadena.length - 1] !== "listado_encuestas.php") {
        $("td").dblclick(function () {            
            var OriginalContent = $(this).text();      
            //console.log(OriginalContent);
            //console.log($(this).attr('id'));
            if ($(this).attr('id').substr(0, $(this).attr('id').length) === "pregunta" || $(this).attr('id').substr(0, 9) === "respuesta" ) {
                $(this).addClass("cellEditing");
                $(this).html("<input type='text' value='" + OriginalContent + "' />");
                $(this).children().first().focus();
                var id_respuesta = $(this).attr('data-idrespuesta');
                var idpregunta = $(this).attr('data-idpregunta');//respuesta
                var id_encuesta = $(this).attr('data-idencuesta');         
                var opc = $(this).attr('data-option');
                var id_pregunta = $(this).attr('data-id_pregunta');             
                $(this).children().first().blur(function (e) {
                    var newContent = $(this).val();
                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");
                    var campos2 = {'opcion':opc, 'id_respuesta': id_respuesta, 'id_pregunta': id_pregunta, 'id_encuesta': id_encuesta,'respuesta': newContent,'idpregunta_R':idpregunta,'idpregunta':id_pregunta};
                    $.ajax({
                        data: campos2,
                        url: 'modelo/editar.php',
                        type: 'post',
                        success: function (response) {
                            //console.log(response);
                            if(response == 1){
                                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=editar";
                            }else{
                                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=errorEditar";
                            }            
                        }
                    });
                });
            }
        });
    }
});

function eliminar(id, id_encuesta, opc) {

    var campos2 = {'id': id, 'id_encuesta': id_encuesta, 'opc': opc};

    $.ajax({

        data: campos2,
        url: 'modelo/eliminar.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response === '1') {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=eliminarRespuesta";
            } else {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=errorEliminar";
            }
        }
    });
}

function eliminarEncuesta() {

    var campos2 = {'id_encuesta': $('#id_encuestav').val()};

    $.ajax({

        data: campos2,
        url: 'modelo/eliminarEncuesta.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response === '1') {
                window.location.href = "listado_encuestas.php?mensaje=eliminarEncuesta";
                $('#id_encuestav').val("");
            } else {
                window.location.href = "listado_encuestas.php?mensaje=errorEliminarEncuesta";
            }
        }
    });
}

var campos2 = {};

function validarPregunta(id_encuesta, id_pregunta) {
    campos2 = {'id_encuesta': id_encuesta, 'id_pregunta': id_pregunta};
    $.ajax({
        data: campos2,
        url: 'modelo/validarPregunta.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response === '0') {
                eliminarPregunta();
            } else {
                $('#launchModal').trigger("click");
            }
        }
    });
}

function  eliminarPregunta() {

    $.ajax({
        data: campos2,
        url: 'modelo/eliminarPregunta.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response === '1') {
                window.location.href = "editarEncuesta.php?id=" + campos2.id_encuesta + "&mensaje=eliminarPregunta";
            } else {
                window.location.href = "editarEncuesta.php?id=" + campos2.id_encuesta + "&mensaje=errorEliminarPregunta";
            }
            campos2 = {};
        }
    });
}

function  editarTitulo(id_encuesta) {

    var campos = {'titulo': $('#titulo2').val(), 'id_encuesta': id_encuesta};

    $.ajax({
        data: campos,
        url: 'modelo/editarTitulo.php',
        type: 'post',
        success: function (response) {
            //console.log(response);
            if (response === '1') {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=edtarTitulo";
            } else {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=errorEditarTitulo";
            }
        }
    });
}

function agregar(id_encuesta) {
    var campos2 = {'pregunta': $('#selec_preguntas2').val(), 'respuesta': $('#respuesta2').val(), 'id_encuesta': id_encuesta};

    $.ajax({

        data: campos2,
        url: 'modelo/addRespuesta.php',
        type: 'post',
        success: function (response) {

            if (response == '1') {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=agregarRespuesta";
            } else {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=errorAgregar";
            }
        }
    });
}

function agregarPregunta(id_encuesta) {

    var campos2 = {'pregunta': $('#pregunta2').val(), 'id_encuesta': id_encuesta};

    $.ajax({

        data: campos2,
        url: 'modelo/addPregunta.php',
        type: 'post',
        success: function (response) {
            if (response === '1') {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=agregarPregunta";
            } else {
                window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=errorPregunta";
            }
        }

    });
}

function setId(id_encuesta) {

    $('#id_encuestav').val(id_encuesta);
}

function validarTA() {
    $(".c").attr("aria-checked", "false");
    $(".c").removeClass("checked");
}


function addPreguntaRespuesta(id_pregunta, id_pregunta_respuesta, opcion, respuestaTA) {

    var objeto = {"id_pregunta": id_pregunta, "id_pregunta_respuesta": id_pregunta_respuesta, "opcion": opcion, "respuestaTA": respuestaTA};
    validarArrayLLenos.push(objeto);

}

$('#btn_enviar').click(function () {
    var validarArrayVacios = [];
    var validarArrayLLenos = [];
    var countErrorres = 0;
    var countErrorres2 = 0;

    var capturaId = {"nombre": "nombre", "documento": "documento", "telefono": "telefono", "email": "email"};
    for (var elemento in capturaId) {
        if ($("#" + elemento).val() === "") {
            $("#" + elemento).css("border", "1px solid red");
            countErrorres++;
        } else {
            $("#" + elemento).css("border", "");
        }
    }

    var form = $("#form_encuesta");
    form.find(':input').each(function () {
        var elemento = this;
        var attrib = (elemento.checked === false) ? "" : elemento.checked;
        var res = elemento.id.split("_");
        var id_pregunta_respuesta = elemento.getAttribute('data-idrespuesta');
        var opcion = elemento.getAttribute('data-opcion');
        if (elemento.type === "textarea") {
            attrib = elemento.value;
        }
        if (res.length > 1) {
            res = res[1];
        } else {
            res = res[0];
        }

        var val = {"id_pregunta": res, "respuestaTA": attrib, "id_pregunta_respuesta": id_pregunta_respuesta, "opcion": opcion};
        if (elemento.id !== "nombre" && elemento.id !== "documento" && elemento.id !== "telefono" && elemento.id !== "email" && elemento.id !== "btn_enviar") {
            validarArrayVacios.push(val);
        }

    });

    for (var itemA in validarArrayVacios) {
        var val = {"id_pregunta": validarArrayVacios[itemA].id_pregunta, "id_pregunta_respuesta": validarArrayVacios[itemA].id_pregunta_respuesta, "respuestaTA": validarArrayVacios[itemA].respuestaTA, "opcion": validarArrayVacios[itemA].opcion};
        if (validarArrayVacios[itemA].respuestaTA !== "") {
            validarArrayLLenos.push(val);
        }
    }

    if (countErrorres > 0) {//NOTIFICACIÓN DE CAMPOS REQUERIDOS
        $.notify("Los campos deben ser obligatorios", "info");
        return;
    }

    validarArrayVacios.forEach(function (elemento, indice) {//NOTIFICACIÓN DE CAMPO RESPUESTA REQUERIDO
        if (findElementInArray(elemento.id_pregunta, validarArrayLLenos)) {
            $("#pregunta_" + elemento.id_pregunta).css("border", "");
        } else {
            $("#pregunta_" + elemento.id_pregunta).css("border", "1px solid red");
            countErrorres2++;

        }
    });
    
    if (countErrorres2 > 0) {//NOTIFICACIÓN DE RADIO BUTTONS SELECCIONADOS
        $.notify("Debe seleccionar una respuesta", "info");
        return;
    }

    if (!validaEmail()) {//VALIDAR CAMPO EMAIL
        $.notify("Ingrese un correo valido", "info");
        return;
    }

    var objeto = {"id_encuesta": $('#btn_enviar').data('id'), "nombre": $('#nombre').val(), "email": $('#email').val(), "documento": $('#documento').val(), "telefono": $("#telefono").val(), "respuestas": JSON.stringify(validarArrayLLenos)};
    $.ajax({
        data: objeto,
        url: 'modelo/guardarInfoUsuario.php',
        type: 'post',
        success: function (response) {
            console.log(response);

            if (response === '1') {
                window.location.href = "redireccionPagina.html?mensaje=registroEncuestaUsu";

            } else {
                window.location.href = "redireccionVistaUsu.php?id=" + $('#btn_enviar').data('id') + "&mensaje=errorRegistroEncuestaUsu";
            }
        }

    });

});


function findElementInArray(id, myArr2) {
    var result = false;
    myArr2.forEach(function (elemento, indice) {
        if (elemento.id_pregunta === id) {
            result = true;
        }
    });
    return result;
}

function removeDuplicates(originalArray, prop) {
    var newArray = [];
    var lookupObject = {};

    for (var i in originalArray) {
        lookupObject[originalArray[i][prop]] = originalArray[i];
    }

    for (i in lookupObject) {
        newArray.push(lookupObject[i]);
    }
    return newArray;
}

function clearoptions(id) {
    $('input[name=pregunta' + id + ']').attr('checked', false);
}

function validaEmail() {
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (expr.test($('#email').val().trim())) {
        return true;
    } else {
        return false;
    }
}