<?php
session_start();
require("funciones/pdo.php");
if($_SESSION["rol"] != "admin"){
    echo "<script> window.location.href='inicio.php' </script>";
}
$subSeccionAdmin = null;
$mostrarBloque="hide";
if(isset($_GET["adminSedes"])){
    $subSeccionAdmin = "componentesAdmin/adminSedes.php";
    $mostrarBloque="show";
}
if(isset($_GET["adminCategorias"])){
    $mostrarBloque="show";
    $subSeccionAdmin = "componentesAdmin/adminCategorias.php";
    
}
if(isset($_GET["adminArticulos"])){
    $mostrarBloque="show";
    $subSeccionAdmin = "componentesAdmin/adminArticulos.php";
}
if(isset($_GET["adminUsuarios"])){
    $mostrarBloque="show";
    $subSeccionAdmin = "componentesAdmin/adminUsuarios.php";
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
        <link href="css/master.css" rel="stylesheet">
        <link href="css/master1.css" rel="stylesheet">
    </head>
    <body>
        <div class="contenedorPrincipal">
            <div class="header">
                <?php require("componentes/header.php")?>
            </div>
            <div class="d-flex align-items-center justify-content-center">

                <h2>Sitio en construcción</h2>

            </div>
            <!-- <div>
                Cada articulo tiene asociada una categoria a la cual pertenece. Si al crear un articulo, la categoria no figura en el listado seleccionable, primero deberá crearse la categoria en la opción correspondiente.
                <br>
                Cada usuario tiene asociada una sede y una casa respectiva, si al momento de crear el usuario, la sede no figura en el listado seleccionable la misma dberá crearse en la opcion crear Sede.
                <br>
                La eliminacion (de articulos, usuarios, sedes o categorias) funciona inhabilitando la opcion seleccionada, pero no borrandola de base de datos, por lo que si se dese habilitar nuevamente, no debe crearse de cero, si no en la opcion editar, modificar el campo "habilitado"
                <br>
                Puede resetear la contraseña de un usuario ingresando a la opcion Admin/Usuarios, y luego seleccionando la opcion editar. Dentro el
            </div> -->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>           
    </body>
</html>