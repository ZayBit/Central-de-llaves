<?php include 'header.php';?>
<?php $ruta = 'importantes.php';
    // Si no existe entonces se redirecciona al archivo config_init.php
    if(!file_exists('config_db.php')){
        header('Location:' . RUTA . 'init_db.php');
    }
?>

    <div class="container">
        <aside class="top-content">
        <?php if(isset($_SESSION['usuario'])): ?>
            <section class="new-key">
                    <h3>Agregar una nueva llave</h3>
                <button class="btn-new-key"><i class="fas fa-key"></i> Crear nueva llave</button>
            </section>
<?php endif; ?>
        </aside>
        <main class="main-content">
        <?php if(isset($_SESSION['usuario'])): ?>
            <div class="table">
                <div class="header-table">
                <button class="btn-select" name="passNormales"><a href="index.php">Contraseñas generales</a></button>
                    <button class="btn-select btn-active" name="passImportantes"><a href="importantes.php?p=<?php echo pagina_actual();?>">Contraseñas Importantes</a></button>
                </div>
                <div class="body-table">
  
                    <div class="item-table p2 section-active">
                    <?php if(obtener_post($configPY['post_por_pagina'],$_SESSION['usuario'],'','importante',$conexion)) :?>
                        <table cellmargin="0" class="table-private">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Enlace</th>
                                    <th>Usuario/Correo</th>
                                    <th>Estado</th>
                                    <th>Contraseña</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                     
                            <?php foreach(obtener_post($configPY['post_por_pagina'],$_SESSION['usuario'],'','importante',$conexion) as $i) :?>
                           
                            <tr>
                                    <td><?php echo $i['nombre'];?></td>
                                    <td><a href="<?php echo $i['enlace'];?>"><?php echo $i['nombre_enlace'];?></a></td>
                                    <td><?php echo $i['usuario_correo'];?></td>
                                    <td><span class="estado-<?php echo $i['estado'];?>"><?php echo $i['estado'];?></span></td>
                                    <td><span class="password-in-td"><?php echo $i['pass'];?></span></td>
                                    <td>
                                        <form action="<?php echo $_SERVER['PHP_SELF']?>?p=<?php echo pagina_actual();?>" method="post">
                                            <input type="hidden" name="id" value="<?php echo $i['id']?>">
                                            <button value="abrirModal" name="accion"><i class="fas fa-pen"></i></button>
                                            <button value="eliminar" name="accion"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                             
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
           
            
            <?php include 'paginacion.php';?>
            <?php else:  ?>
<h1>No hay llaves</h1>
                        <?php endif; ?>
                        <?php endif; ?>
        </main>
    </div>
<?php include 'footer.php';?>