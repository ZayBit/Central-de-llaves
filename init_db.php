<?php include 'header.php';?>
<?php 

if(file_exists('config_db.php')){
    header('Location:'.RUTA);
}

if(isset($_POST['conexionBtn'])){
    $init_namedb = (isset($_POST['namedb'])) ? $_POST['namedb'] :'';
    $init_userdb = (isset($_POST['userdb'])) ? $_POST['userdb'] :'';
    $init_passdb = (isset($_POST['passdb']))? $_POST['passdb'] :'';
    $init_serverdb = (isset($_POST['serverdb'])) ? $_POST['serverdb'] :'';

    if($init_namedb != '' && $init_userdb != '' && $init_serverdb != ''){
        $testArchivo = fopen('config_db.php','w') or die('No se puede abrir o crear esye archivo');
        $configPHP = "
        <?php
            // Configuracion inicial
        
            // Configuracion de la base de datos
           define('DB_HOST','$init_serverdb');
           define('DB_NAME','$init_namedb');
           define('DB_USER','$init_userdb');
           define('DB_PASSWORD','$init_passdb');
        ";
        
        fwrite($testArchivo,$configPHP);
        fclose($testArchivo);
            header('Location:' .RUTA);
    }else{
        header('Location: init_db.php');
    }


}

?>
    <div class="container">
        <div class="db_init_content">
            <h1>Configuracion inicial</h1>
            <p>Crea las conexiones a la base de datos</p>
    <form action="" method="post">
        <input type="text" pattern=".{5,50}" placeholder="nombre de la base de datos" name="namedb" require>
        <input type="text" pattern=".{2,50}" placeholder="Usuario de la base de datos" name="userdb" require>
        <input type="text" pattern=".{0,100}" placeholder="Contraseña de la base de datos" name="passdb" require>
        <input type="text" pattern=".{5,50}" placeholder="Servidor de la base de datos" name="serverdb" require>
        <button name="conexionBtn">Conectarse</button>
    </form>
        </div>
    </div>
