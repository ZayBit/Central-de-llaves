<div class="paginacion">
<?php 
    
    $numero_paginas = numero_paginas($configPY['post_por_pagina'],$conexion);
   
    ?>

    <ul>
        <?php if(pagina_actual() === 1):?>
        <li class="pagina-inactiva"><i class="fas fa-angle-double-left"></i></li>
        <?php else:?>

        <li><a href="<?php echo $ruta?>?<?php if($buscar){echo 'buscar='.$buscar;}?>&p=<?php echo pagina_actual() -1?>"><i
                    class="fas fa-angle-double-left"></i></a></li>
        <?php endif;?>
   
        
        <?php for($i = 1; $i <= $numero_paginas;$i++):?>
        
        <?php if(pagina_actual() === $i):?>
        <li class="pagina-activa"><?php echo $i?></li>
        <?php else:?>
        
        <li><a
                href="<?php echo $ruta?>?<?php if($buscar){echo 'buscar='.$buscar .'&';}?>p=<?php echo $i?>"><?php echo $i?></a>
        </li>

        <?php endif;?>
        <?php endfor;?>
       
        <?php if(pagina_actual() == $numero_paginas):?>
        <li class="pagina-inactiva"><i class="fas fa-angle-double-right"></i></li>
        <?php else:?>
        <li><a
                href="<?php echo $ruta?>?<?php if($buscar != ''){echo "buscar=$buscar&";}?>p=<?php echo pagina_actual() + 1?>"><i
                    class="fas fa-angle-double-right"></i></a></li>
        <?php endif;?>
   
    </ul>
</div>