<!DOCTYPE html>
<html>
<head>
   <title>Sistema de Gestión Odontológica</title>
   <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
   <link rel="stylesheet" type="text/css" href="Vista/css/estilos2.css">
</head>
<body>
   <div id="contenedor">
      <div id="encabezado">
            <h1>Sistema de Gestión Odontológica</h1>
      </div>
      <ul id="menu">
            <li><a href="index.php">Inicio</a> </li>
            <li><a href="index.php?accion=login">Iniciar Sesion</a> </li>
            <li><a href="index.php?accion=register">Crear Cuenta</a> </li>
      </ul>
      <div id="contenido">
         <h2>Registro de Pacientes</h2>
         <div class="form-box">
            <form action="index.php?accion=procesarRegistroPaciente" method="POST">
               <input type="text" name="identificacion" placeholder="Identificación" required>
               <input type="text" name="nombres" placeholder="Nombres" required>
               <input type="text" name="apellidos" placeholder="Apellidos" required>
               <input type="date" name="fechaNacimiento" required>
               <select name="sexo" required>
                  <option value="">Sexo</option>
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
               </select>
               <br> <br>
               <input type="email" name="correo" placeholder="Correo" required>
               <input type="password" name="password" placeholder="Contraseña" required>
               <button type="submit">Registrarse</button>
            </form>
         </div>
      </div>
   </div>
</body>
</html>