<?php 

    // recibir los datos de buscar por el metodo GET
    $buscar = (isset($_GET['buscar'])) ? limpiarDatos($_GET['buscar']) :'';

    // variables relacionadas al usuario
    $usuario = (isset($_POST['usuario'])) ? limpiarDatos($_POST['usuario']) :'';
    $userPass = (isset($_POST['userPass'])) ? limpiarDatos($_POST['userPass']) :'';
    // variable que se utilizara simplemente para comprobar si la contraseña es igual a la anterior
    $userPass2 = (isset($_POST['userPass2'])) ? limpiarDatos($_POST['userPass2']) :'';


    /* este switch tiene distintos casos para: 
        registro de un nuevo usuario,
        iniciar sesion,
        cerrar sesion
    */
$btnAcciones = (isset($_POST['accion'])) ? $_POST['accion'] :'';
    switch($btnAcciones){
               // registrar a un nuevo usuario
               case 'registrarse':
               registrarse($usuario,$userPass,$userPass2,$error,$conexion);
               if(!registrarse($usuario,$userPass,$userPass2,$error,$conexion)){
                   $error = 'El usuario ya existe';     
               }
              
           break;
           // Iniciar sesion
           case 'iniciarSesion':
           // Se pasa la contraseña recibida con hash (sha512) para comparar la contraseña de la base de datos
               $userPass = hash('sha512',$userPass);
           // Funcion para iniciar sesion 
               iniciarSesion($usuario,$userPass,$conexion);
               if(!iniciarSesion($usuario,$userPass,$conexion)){
                   $error = 'El usuario o la contraseña no existen';     
               }
           break;
           // Cerrar sesion
           case 'cerrarSesion':
           // destruir la sesion existente
               session_destroy();
           // caducar la cookie 'usuario' 
               setcookie('usuario','',time() -3600);
           // redireccionar a login.php para volver a iniciar sesion si se es requerido 
               header('Location:'.RUTA.'login.php');
           break;
    }

        //funcion para iniciar sesion
        function iniciarSesion($usuario,$userPass,$conexion){
            $comprobar = $conexion->prepare('SELECT * FROM usuarios WHERE nombre=:usuario AND pass=:pass');
            $comprobar->execute(array(':usuario' => $usuario,':pass'=> $userPass));
            $comprobarUsuario = $comprobar->fetch(); 
    
            if($comprobarUsuario){
                setcookie('usuario',$usuario,time() + 360 * 24 * 60 * 60);
                header('Location:'.RUTA);
            }
        }
        // funcion para crear un usuario
        function registrarse($usuario,$userPass,$userPass2,$error,$conexion){
    
            if($userPass == $userPass2){
                $userPass = hash('sha512',$userPass);
                $comprobar = $conexion->prepare('SELECT * FROM usuarios WHERE nombre=:usuario');
                $comprobar->execute(array(':usuario' => $usuario));
                $comprobarUsuario = $comprobar->fetch(); 
    
            if(!$comprobarUsuario){
                $registrar = $conexion->prepare('INSERT INTO usuarios(nombre,pass) VALUES(:nombre,:pass)');
                $registrar->execute(array(
                    ':nombre' => $usuario,
                    ':pass' =>  $userPass
                ));
                setcookie('usuario',$usuario,time() + 360 * 24 * 60 * 60);
                header('Location:'.RUTA);
            }
            }
    
        }
    
        // Comprobar si existe la cookie seteada de usuario
        if(isset($_COOKIE['usuario'])){
            // Crear una sesion con el valor de cookie
            $_SESSION['usuario'] = $_COOKIE['usuario'];
        }
    
        // Comprobar si existe una sesion con el nombre de "usuario"
        if(isset($_SESSION['usuario'])){
            $llavesDelUsuario = $conexion->prepare('SELECT * FROM llaves WHERE usuario=:usuario');
            $llavesDelUsuario->execute(array(':usuario'=> $_SESSION['usuario']));
            $llaves = $llavesDelUsuario->fetchAll();
        }

?>