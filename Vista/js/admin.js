/* Formulario Insertar Medicos */
$(document).ready(function(){
    $("#frmMedico").dialog({
        autoOpen: false,
        height: 310,
        width: 400,
        modal: true,
        buttons: {
            "Insertar":insertarMedico,
            "Cancelar":cancelar
        }
    });
});

/* Medicos */
function medicoFormulario(){
    documento = "" + $("#asignarDocumento").val();
    $("#MedIdentificacion").attr("value",documento);
    $("#frmMedico").dialog('open');
}

function insertarMedico(){
    queryString = $("#agregarMedico").serialize();
    url = "index.php?accion=ingresarMedicos&" + queryString ;
    $.get(url, function(respuesta){
        if(respuesta.includes("existe") || respuesta.includes("identificación") || respuesta.includes("correo")){
            alert(respuesta);
        } else if(respuesta.includes("exito")) {
            location.reload();
        } else {
            alert("Error al ingresar el médico.");
        }
    });
    $("#frmMedico").dialog('close');
}

function cancelar(){
    $(this).dialog('close');
}

function confirmarCancelarMedico(identificacion){
    if(confirm("Esta seguro de eliminar el medico con identificacion " + identificacion)){
        $.get("index.php",{accion:'confirmarEliminarMedico',identificacion:identificacion},function(mensaje)
        { 
            alert(mensaje);
            location.reload();
        });
    }
}

/* Formulario Insertar Pacientes */
$(document).ready(function(){
    $("#frmPaciente").dialog({
        autoOpen: false,
        height: 310,
        width: 400,
        modal: true,
        buttons: {
            "Insertar":insertarPaciente,
            "Cancelar":cancelar
        }
    });
});

/* Pacientes */
function pacienteFormulario(){
    documento = "" + $("#asignarDocumento").val();
    $("#MedIdentificacion").attr("value",documento);
    $("#frmPaciente").dialog('open');
}

function insertarPaciente(){
    queryString = $("#agregarPaciente").serialize();
    url = "index.php?accion=ingresarPaciente&" + queryString ;
    $.get(url, function(respuesta){
        if(respuesta.includes("existe") || respuesta.includes("identificación") || respuesta.includes("correo")){
            alert(respuesta);
        } else if(respuesta.includes("exito")) {
            location.reload();
        } else {
            alert("Error al ingresar el paciente.");
        }
    });
    $("#frmPaciente").dialog('close');
}

function confirmarCancelarPaciente(identificacion){
    if(confirm("Esta seguro de eliminar el paciente con identificacion " + identificacion)){
        $.get("index.php",{accion:'confirmarEliminarPaciente',identificacion:identificacion},function(mensaje)
        { 
            alert(mensaje);
            location.reload();
        });
    }
}

