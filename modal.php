<div class="modal-new-key <?php echo $abrirModal;?>">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <label for="Nombre">Nombre de la llave</label>
            <input type="text" placeholder="Nombre" id="Nombre" name="nombreLlave" value="<?php echo $nombreLlave;?>" required>
            <label for="link">Enlace</label>
            <input type="text" placeholder="Nombre del enlace" id="link" name="nombreLink" value="<?php echo $nombreLink;?>">
            <input type="text" placeholder="Enlace (URL)" name="urlLink" value="<?php echo $urlLink;?>">
            <label for="Descripcion">Usuario/Correo</label>
            <input type="text" placeholder="Usuario o Correo" id="Descripcion" name="usuarioCorreo" value="<?php echo $usuarioCorreo;?>" required>
            <label>Estado</label>
            <select name="estado">
                <option <?php if($estado == 'activo'){echo 'selected';} ?>  value="activo">Activo</option>
                <option <?php if($estado == 'inactivo'){echo 'selected';} ?>  value="inactivo">Inactivo</option>
            </select>
            <label for="password">Contraseña</label>
            <input type="password" name="passLlave" id="password" placeholder="Contraseña" value="<?php echo $passLlave;?>" required>
            <label>Importancia</label>
            <select name="importancia">
                <option <?php if($importancia == 'importante'){echo 'selected';} ?> value="importante">Importante</option>
                <option <?php if($importancia == 'noImportante'){echo 'selected';} ?> value="noImportante">No importante</option>
            </select>
            <label>Crear llave</label>
            <div class="buttons-section-new-key">
                <?php if($abrirModal == ''):?>
                <button value="crear" name="accion">Crear</button>
                <?php else:?>
                <button value="actualizar" name="accion">Actualizar</button>
                <button value="eliminar" name="accion">Eliminar</button>
                <?php endif;?>
                <button ><a href="<?php echo $_SERVER['PHP_SELF']?>?p=<?php echo pagina_actual();?>">Cancelar</a></button>
            </div>
        </form>
    </div>