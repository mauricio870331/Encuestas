var DATA = [];
var DATA2 = [];

$("#enviar").click(function () {//BOTÒN GUARDAR

    if ($('#titulo').val() == "") {
        showAlert("La encuesta debe tener un título", "error", 250, 60);//VALIDA ARRAY PREGUNTAS QUE AL MENOS TENGA 1 VAlOR
        return;
    }

    if (DATA.length == 0) {
        showAlert("Debe ingresar al menos una pregunta", "error", 250, 60);//VALIDA ARRAY PREGUNTAS QUE AL MENOS TENGA 1 VAlOR
        return;
    }


    if (DATA2.length == 0) {
        showAlert("Las preguntas ingresadas no tienen respuesta", "error", 250, 60);//VALIDA ARRAY PREGUNTAS QUE AL MENOS TENGA 1 VAlOR
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

    if ($('#pregunta').val() != "") {
        $('#tbl_preguntas').append('<tr id="' + index + '"><td id="td_id">' + $('#pregunta').val() + '</td><td><i class="fa fa-eraser" aria-hidden="true" onClick="removerPregunta(' + index + ',1)" style="color:blue;cursor:pointer"></i></td></tr>');
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
    $('#tbl_respuestas').append('<tr id="' + indexR + '"><td id="td_id3">' + $('#selec_preguntas').val() + '</td><td id="td_id2">' + $('#respuesta').val() + '</td><td><i class="fa fa-eraser" aria-hidden="true" onClick="removerPregunta(' + indexR + ',2)" style="color:blue;cursor:pointer"></i></td></tr>');
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
    if ($("#notificaciones").length == 0) {
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

    $("td").dblclick(function () {
        var OriginalContent = $(this).text();
        if ($(this).attr('id').substr(0, 8) !== "pregunta") {
            $(this).addClass("cellEditing");
            $(this).html("<input type='text' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            var id_respuesta = $(this).attr('data-idrespuesta');
            var id_pregunta = $(this).attr('data-idpregunta');
            var id_encuesta = $(this).attr('data-idencuesta');
            $(this).children().first().blur(function (e) {

                var newContent = $(this).val();
                $(this).parent().text(newContent);
                $(this).parent().removeClass("cellEditing");
                var campos2 = {'id_respuesta': id_respuesta, 'id_pregunta': id_pregunta, 'id_encuesta': id_encuesta, 'respuesta': newContent};

                $.ajax({
                    data: campos2,
                    url: 'modelo/editar.php',
                    type: 'post',
                    success: function (response) {
                        if (response === 1) {
                            window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=editar";
                        } else {
                            window.location.href = "editarEncuesta.php?id=" + id_encuesta + "&mensaje=errorEditar";
                        }
                    }
                });
            });
        }
    });
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
    
    var campos = {'titulo':$('#titulo2').val(),'id_encuesta':id_encuesta};
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
            if (response === '1') {
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