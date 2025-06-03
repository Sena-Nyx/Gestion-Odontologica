$(document).ready(function() {
    var rol = typeof rolUsuario !== "undefined" ? rolUsuario : 0;
    var menu = $("#menu");
    menu.empty();

    if (rol == 1) { // Administrador
        menu.append('<li><a href="index.php?accion=asignar">Asignar</a></li>');
        menu.append('<li><a href="index.php?accion=consultar">Consultar Cita</a></li>');
        menu.append('<li><a href="index.php?accion=cancelar">Cancelar Cita</a></li>');
        menu.append('<li><a href="index.php?accion=medicos">Medicos</a></li>');
        menu.append('<li><a href="index.php?accion=paciente">Pacientes</a></li>');
    } else if (rol == 2) { // Paciente
        menu.append('<li><a href="index.php?accion=consultar">Consultar Cita</a></li>');
        menu.append('<li><a href="index.php?accion=cancelar">Cancelar Cita</a></li>');
    } else if (rol == 3) { // Medico
        menu.append('<li><a href="index.php?accion=consultar">Consultar Cita</a></li>');
    } 
});