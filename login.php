<?php require 'header.php';?>

<?php 

    if(isset($_SESSION['usuario'])){
        header('Location:'.RUTA);
    }

?>
        <div class="container-form">
                <div class="content-formu">
                        <h2>Iniciar sesion</h2>
                        <form action="" method="post">
                            <label for="">Nombre de usuario</label>
                            <input type="text" placeholder="Nombre" name="usuario">
                            <label for="">Contraseña</label>
                            <input type="text" placeholder="contraseña" name="userPass">
                            <button value="iniciarSesion" name="accion">Iniciar sesion</button>
                            <div class="error-ms">
                            <?php if($error) : ?>
                           <p class="error-ms"><?php echo $error?></p>
                                <?php endif;?>
                    </div>
                        </form>
                        <div class="footer-form">
                            <a href="#">Terminos</a>
                            <p>Central de llaves</p>
                            <a href="<?php echo 'loging.php'?>">Crear cuenta?</a>
                    </div>
                    </div>


        </div>
