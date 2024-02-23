<?php
if($_SESSION["autenticado"] != true){
    echo "<script>location.href='index.php';</script>";
}
$nombre = $_SESSION["name"];
$corte = strpos($nombre, " ");
$nombre = substr($nombre, 0, $corte);
date_default_timezone_set('America/Argentina/Cordoba');
$date = date("d-m-Y");
$mostrarBotonAdmin = "hide";
if($_SESSION["rol"] == "admin" || $_SESSION["rol"] == "general"){
    $mostrarBotonAdmin = "";
}

?>
<html>
    <head>
        <title>Pedidos Sí</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link href="css/header.css" rel="stylesheet">
    </head>
    <div>
        <div class="row rowHeader d-flex justify-content-around">
            <div class="col-3 col-md-1 mitadHeader logoInicioHeader" onclick="redirect('inicio')">
            </div>
            <div class="col-1 col-md-3">
            </div>
            <div class="col-7 col-md-4 mitadHeader d-flex align-items-center justify-content-end">
                <div class="row boxUser">
                    <div class="col-8 textoBoxUser">
                        <span><?php echo $nombre ?></span>
                        <br>
                        <span><?php echo $date ?></span>
                    </div>
                    <div class="btn-group  col-4">
                        <button type="button" class="btn iconoBurguer " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ☰
                        </button>
                        <div class="dropdown-menu dropdown-menu-right m-0 p-0">
                            <div name="inicio" class="row burguerButton" onclick="redirect('inicio')" id="btnInicio" data-toggle="tooltip" data-placement="bottom" >
                                <div class="nameButtonAside">Inicio</div>
                            </div>
                            <div name="iniciarPedido" class="row burguerButton" id="iniciarPedido" onclick="redirect('iniciarPedido')" data-toggle="tooltip" data-placement="bottom">
                                <div class="nameButtonAside">Iniciar Pedido</div>
                            </div>
                            <div name="perfil" class="row burguerButton" onclick="redirect('ajustes')" id="btnAjustes" data-toggle="tooltip" data-placement="bottom">
                                <div class="nameButtonAside">Ajustes</div> 
                            </div>
                            <div name="admin" class="row burguerButton <?php echo $mostrarBotonAdmin?>" onclick="redirect('admin')" onclick="resetStorage()" id="admin" data-toggle="tooltip" data-placement="bottom">
                                <div class="nameButtonAside botonAdmin">Admin</div>
                            </div>
                            <div name="pedidos" class="row burguerButton" id="pedidos" onclick="redirect('pedidos')" data-toggle="tooltip" data-placement="bottom">
                                <div class="nameButtonAside">Pedidos</div>
                            </div>
                            <div name="ayuda" class="row burguerButton <?php echo $mostrarBotonAdmin?>" onclick="redirect('ayuda')" id="ayuda" data-toggle="tooltip" data-placement="bottom">
                                <div class="nameButtonAside botonAdmin">Ayuda</div>
                            </div>
                            <div name="desloguear" class="row burguerButton" id="desloguear" onclick="redirect('destroy')" data-toggle="tooltip" data-placement="bottom">
                                <div class="nameButtonAside">Cerrar sesión</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <script type="text/javascript"  src="./js/funcionesCompartidas.js"></script> 
</html>  