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
            <h2>Inicio de Sesion</h2>
            <?php
               if (isset($_GET['registro']) && $_GET['registro'] == 'exito') {
                  echo '<div class="form-box" style="color:green; text-align:center; margin-bottom:15px;">
                           Se ha registrado correctamente! Ahora puedes iniciar sesión.
                        </div>';
               }
               if (isset($_GET['error']) && $_GET['error'] == '1') {
                  echo '<div class="form-box" style="color:red; text-align:center; margin-bottom:15px;">
                           Credenciales incorrectas. Intenta de nuevo.
                        </div>';
               }
            ?>
            <div class="form-box">
               <form class="register-form" method="POST" action="index.php?accion=procesarLogin">
                  <input type="text" name="correo" placeholder="correo" required />
                  <input type="password" name="password" placeholder="contraseña" required />
                  <select name="rol" id="rol" required>
                     <option value="">--- Seleccione un rol ---</option>
                     <?php
                     if(isset($roles)){
                        while($rol = $roles->fetch_object()){
                              echo "<option value='{$rol->codigo}'>{$rol->rol}</option>";
                        }
                     }
                     ?>
                  </select>
                  <br> <br>
                  <button type="submit">Iniciar Sesion</button>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>

