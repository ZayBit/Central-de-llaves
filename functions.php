<?php 
    session_start();
    require 'config.php';
    
    define('RUTA',$configPY['ruta_py']);

    // Si el archivo de configuracion config_init.php que se encarga de generar las variables para conectar a la base de datos
    // De igual manera para configurar ciertas cosas de este proyecto
    if(file_exists('config_db.php')){
      
        require 'config_db.php';
        // Crear la conexion a la base de datos
        try{
            // guardar la conexion en la variable $conexion
            $conexion = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
            // Preguntar si la tabla "llaves" exista y si no existe la crea
            $TABLE_EXIST_KEYS = $conexion->query('SELECT * FROM llaves');
            if(!$TABLE_EXIST_KEYS){
                $crearTabla = $conexion->prepare('CREATE TABLE llaves(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(150) NOT NULL,nombre_enlace VARCHAR(150) NOT NULL,enlace VARCHAR(600) NOT NULL, usuario_correo VARCHAR(200) NOT NULL,estado VARCHAR(50) NOT NULL,pass VARCHAR(300) NOT NULL,importancia VARCHAR(50) NOT NULL,usuario VARCHAR(150) NOT NULL)');
                $crearTabla->execute();
            }
            // Preguntar si la tabla "usuarios" exista y si no existe la crea
            $TABLE_EXIST_USERS = $conexion->query('SELECT * FROM usuarios');
            if(!$TABLE_EXIST_USERS){
                $crearTabla = $conexion->prepare('CREATE TABLE usuarios(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(150) NOT NULL,pass VARCHAR(300) NOT NULL)');
                $crearTabla->execute();
            }
        // excepción si no tiene exito la conexion
        }catch(PDOException $e){
            // eliminar el archivo "config_db.php"
            unlink('config_db.php');
            // redireccionar a "init_db.php"
            header('Location: ' .RUTA.'init_db.php');
        }
        
    }
 
    // variables relacionadas con la llave creada o por crear
    $id = (isset($_POST['id'])) ? $_POST['id'] :'';
    $nombreLlave = (isset($_POST['nombreLlave'])) ? limpiarDatos($_POST['nombreLlave']) :'';
    $nombreLink = (isset($_POST['nombreLink'])) ? limpiarDatos($_POST['nombreLink']) :'';
    $urlLink = (isset($_POST['urlLink'])) ? limpiarDatos($_POST['urlLink']) :'';
    $usuarioCorreo = (isset($_POST['usuarioCorreo'])) ? limpiarDatos($_POST['usuarioCorreo']) :'';
    $estado = (isset($_POST['estado'])) ? $_POST['estado'] :'';
    $passLlave = (isset($_POST['passLlave'])) ? limpiarDatos($_POST['passLlave']) :'';
    $importancia = (isset($_POST['importancia'])) ? $_POST['importancia'] :'';

    // variable con acciones multiples (recibira el mismo "name" pero con distintos valores)
    $btnAcciones = (isset($_POST['accion'])) ? $_POST['accion'] :'';
    $abrirModal = '';
    // Variable para mostrar futuros errores
    $error = '';

    /* Archivo de funciones del usuario como:
        - El inicio de sesion
        - El registro de un nuevo usuario
        - Cerrar la sesion iniciada 
    */
    if(file_exists('config_db.php')){
        include 'inc/user_functions.php';
    }

    // switch para crear multiples acciones para no tener que crear tantos "name" con distintos nombres
    /* este switch tiene distintos casos para: 
        crear,
        actualizar,
        eliminar,
        mostrar el modal
    */
    switch ($btnAcciones) {
        case 'crear':
            crearLlave($nombreLlave,$nombreLink,$urlLink,$usuarioCorreo,$estado,$passLlave,$importancia,$conexion,$_SESSION['usuario']);
        break;
        case 'actualizar':
            actualizarLlave($nombreLlave,$nombreLink,$urlLink,$usuarioCorreo,$estado,$passLlave,$importancia,$conexion,$id);
        break;
        case 'eliminar':
            eliminarLlave($id,$conexion);
        break;
        // abrir el modal con toda la informacion de la llave seleccionada para editar la llave
        case 'abrirModal':
        // $abrirModal es una variable para mostrar una clase en el DOM
            $abrirModal = 'modal-new-key-active';
        // obtener datos de la llave seleccionada por id
            $prepararLlave = $conexion->prepare('SELECT * FROM llaves WHERE id=:id');
            $prepararLlave->execute(array(':id'=>$id));
            $resultadosLlave = $prepararLlave->fetch();
        
        // resultados de la llave solicitada
            $nombreLlave = $resultadosLlave['nombre'];
            $nombreLink = $resultadosLlave['nombre_enlace'];
            $urlLink = $resultadosLlave['enlace'];
            $usuarioCorreo = $resultadosLlave['usuario_correo'];
            $estado = $resultadosLlave['estado'];
            $passLlave = $resultadosLlave['pass'];
            $importancia = $resultadosLlave['importancia'];
        break;
    }

    // funcion para actualizar la llave
    function actualizarLlave($nombreLlave,$nombreLink,$urlLink,$usuarioCorreo,$estado,$passLlave,$importancia,$conexion,$id){

        $actualizarLlave = $conexion->prepare('UPDATE llaves SET nombre=:nombre,nombre_enlace=:nombre_enlace,enlace=:enlace,usuario_correo=:usuario_correo,estado=:estado,pass=:pass,importancia=:importancia WHERE id=:id');

        $actualizarLlave->execute(array(
            ':nombre' => $nombreLlave,
            ':nombre_enlace' => $nombreLink,
            ':enlace' => $urlLink,
            ':usuario_correo' => $usuarioCorreo,
            ':estado' => $estado,
            ':pass' => $passLlave,
            ':importancia' => $importancia,
            ':id' => $id
        ));
        // Redirigir al inicio
        header('Location:'.RUTA);
    }
    // funcion para eliminar la llave
    function eliminarLlave($id,$conexion){
        $eliminarLlave = $conexion->prepare('DELETE FROM llaves WHERE id=:id');
        $eliminarLlave->execute(array(':id'=>$id));
        header('Location:'.RUTA);
    }
    // funcion para eliminar la llave
    function crearLlave($nombreLlave,$nombreLink,$urlLink,$usuarioCorreo,$estado,$passLlave,$importancia,$conexion,$usuario){
        $crearLlave = $conexion->prepare('INSERT INTO llaves(nombre,nombre_enlace,enlace, usuario_correo,estado,pass,importancia,usuario) VALUES(:nombre,:nombre_enlace,:enlace, :usuario_correo,:estado,:pass,:importancia,:usuario)');
        
        $crearLlave->execute(array(
            ':nombre' => $nombreLlave,
            ':nombre_enlace' => $nombreLink,
            ':enlace' => $urlLink,
            ':usuario_correo' => $usuarioCorreo,
            ':estado' => $estado,
            ':pass' => $passLlave,
            ':importancia' => $importancia,
            ':usuario' => $usuario
        ));
        header('Location:'.RUTA);
    }

    // Obtener la pagina actual por el metodo GET
    function pagina_actual(){
        return (isset($_GET['p'])) ? (int)$_GET['p'] :1;
    }

    // Obtener los post 
    function obtener_post($post_por_pagina,$usuario,$buscar,$importancia,$conexion){
        // $inicio = la pagina actual del metodo GET que se multiplica por los posts_por_pagina y se resta los post por pagina
        $inicio = (pagina_actual() > 1) ? pagina_actual() * $post_por_pagina - $post_por_pagina :0;

        // sentencia para obtener el calculo de las filas de la tabla (llaves) WHERE el usuario sea igual al iniciado Y que en el valor de importancia tenga (importante O noImportante)
        if(isset($_GET['buscar'])){
            $sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM llaves WHERE usuario='$usuario' AND importancia='$importancia' AND nombre LIKE '%$buscar%' ORDER BY id DESC LIMIT $inicio , $post_por_pagina");
        }else{
            $sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM llaves WHERE usuario='$usuario' AND importancia='$importancia' ORDER BY id DESC LIMIT $inicio , $post_por_pagina");
        }
        $sentencia->execute();
        // retorna la sentencia preparada y executada con fetchAll
        return $sentencia->fetchAll();
    }
    // Obtener el numero de paginas
   function numero_paginas($post_por_pagina,$conexion){
    //Consulta para saber cuantas filas encontro y guardar en total
       $total_post = $conexion->prepare("SELECT FOUND_ROWS() as total");
       $total_post->execute();
       $total_post = $total_post->fetch()['total'];

    //redondea el numero restante hacia arriba con ceil y divide el $total_post entre $post_por_pagina
       $numero_paginas = ceil($total_post / $post_por_pagina);

    //retorna $numero_paginas 
       return $numero_paginas;
   }
    //Funcion para limpiar los strings
   function limpiarDatos($datos){
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
   }
?>