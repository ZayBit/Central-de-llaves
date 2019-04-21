<?php require 'functions.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo RUTA?>/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC|Allerta+Stencil|Amatic+SC|Archivo+Narrow|Arimo|Assistant|Bad+Script|Bitter|Carter+One|Caveat|Caveat+Brush|Changa|Courgette|Crimson+Text|Damion|Dancing+Script|Dosis|Fira+Sans|Handlee|Heebo|Hind|Inconsolata|Kaushan+Script|Lato|Lilita+One|Lobster|Major+Mono+Display|Markazi+Text|Monoton|Mukta|Oswald|PT+Sans|PT+Sans+Narrow|Pacifico|Permanent+Marker|Pinyon+Script|Playfair+Display|Poppins|Questrial|Raleway|Rancho|Righteous|Roboto|Roboto+Condensed|Saira+Extra+Condensed|Source+Sans+Pro|Ubuntu|Ubuntu+Mono|VT323|Work+Sans"
        rel="stylesheet">
</head>

<body>
    <?php if(file_exists('config_db.php')) : ?>
<?php if(isset($_SESSION['usuario'])) :?>
<header>
        <i class="fas fa-user-shield"></i>
        <h1><a href="<?php echo RUTA?>">Central de contraseñas</a></h1>
        <nav>
            <ul>
                <li>
                    <a href="<?php echo RUTA?>">Inicio</a>
                </li>

                <li><form action="search.php" method="GET">
                    <input type="text" placeholder="Buscar llaves" name="buscar" required>
                    <button><i class="fas fa-search"></i></button>
                </form></li>
                <li><span><?php echo $_SESSION['usuario'];?></span></li>
                <li>
                    <form action="" method="POST">
                        <button value="cerrarSesion" name="accion"><i class="fas fa-sign-in-alt"></i></button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <?php endif;?>
    <?php endif;?>
    <?php include 'modal.php';?>