<?php require 'header.php';?>
<?php 

    if(isset($_SESSION['usuario'])){
        header('Location:'.RUTA);
    }

?>
        <div class="container-form">
                <div class="content-formu">
                        <h2>Registrarse</h2>
                        <form action="" method="post">
                            <label for="">Nombre de usuario</label>
                            <input type="text" placeholder="Nombre" name="usuario">
                            <label for="">Contraseña</label>
                            <input type="text" placeholder="contraseña" name="userPass">
                            <label for="">Repetir contraseña</label>
                            <input type="text" placeholder="confirmar contraseña" name="userPass2">
                            <button value="registrarse" name="accion">Crear cuenta</button>
                           <?php if($error) : ?>
                           <p class="error-ms"><?php echo $error?></p>
                                <?php endif;?>
                        </form>
                        <div class="footer-form">
                            <a href="#">Terminos</a>
                            <p>Central de llaves</p>
                            <a href="<?php echo RUTA . 'login.php'?>">Iniciar sesion</a>
                    </div>
                    </div>
    
        </div>
