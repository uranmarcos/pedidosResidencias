<?php
session_start();
if (!$_SESSION["login"]) {
    header("Location: index.html");
}

$rol = $_SESSION["rol"];
$usuario = $_SESSION["usuario"];
// $rol = "usuario";
// if (!$_SESSION["login"]) {
//     header("Location: index.html");
// }

// if ($_SESSION["rol"] != "admin" && $_SESSION["rol"] != "superAdmin") {
//     header("Location: home.php");
// }

// if ($_SESSION["rol"] == "admin" ) {
//     $rol = "admin";
// }
// if ($_SESSION["rol"] == "superAdmin" ) {
//     $rol = "superAdmin";
// }
// if(time() - $_SESSION['login_time'] >= 1000){
//     session_destroy(); // destroy session.
//     header("Location: index.html");
//     die(); 
// } else {        
//    $_SESSION['login_time'] = time();
// }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SI PEDIDOS</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.21/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link href="css/home.css" rel="stylesheet"> 
        <link href="css/modal.css" rel="stylesheet"> 
        <link href="css/notificacion.css" rel="stylesheet"> 
        <link href="css/admin.css" rel="stylesheet"> 
        <!-- <script src="funciones/pdf.js" crossorigin="anonymous"></script> -->
    </head>
    <body>
        <div id="app">
            <?php require("componentes/header.html")?>
            
            
            <div class="container containerMenu">
                
                <!-- START BREADCRUMB -->
                <div class="col-12 p-0">
                    <div class="breadcrumb">
                        <div class="col-12 col-md-6 p-0">
                            <span class="pointer mx-2" @click="irA('home')">Inicio</span>  -  <span class="mx-2 grey"> Admin </span>
                        </div>
                        <div class="col-12 col-md-6 p-0 spanUsuario d-flex justify-content-end">
                            <span>
                                {{usuario}}    
                            </span>
                        </div>
                    </div>
                </div>
                <!-- END BREADCRUMB -->

                <!-- START OPCIONES -->
                <div class="row p-0 contenedorOpciones mt-3">
                    <div v-for="opcion in opciones" class="col-3 contenedorOpcion">
                        <button class="opcion" @click="irA(opcion.toLowerCase())">
                            {{opcion}}
                        </button>
                    </div>
                </div>
                <!-- END OPCIONES -->
            </div>
        </div>

        <script>
            var app = new Vue({
                el: "#app",
                components: {                
                },
                data: {
                    rol: null,
                    usuario: null,
                    opciones: [
                        "Usuarios",
                        "Categorias",
                        "Articulos",
                        "Pedidos"
                    ]
                },
                mounted () {
                    this.rol = "<?php echo $rol; ?>";
                    this.usuario = "<?php echo $usuario; ?>";
                },
                beforeUpdate(){
                    window.onscroll = function (){
                        // Obtenemos la posicion del scroll en pantall
                        var scroll = document.documentElement.scrollTop || document.body.scrollTop;
                    }
                },
                methods:{
                    irA (destino) {
                        switch (destino) {
                            case "admin":
                                window.location.href = 'admin.php';    
                                break; 
                            case "home":
                                window.location.href = 'home.php';    
                                break; 
                            case "usuarios":
                                window.location.href = 'adminUsuarios.php';    
                                break; 
                            case "categorias":
                                window.location.href = 'adminCategorias.php';    
                                break; 
                            case "articulos":
                                window.location.href = 'adminArticulos.php';    
                                break; 
                            case "pedidos":
                                window.location.href = 'home.php';    
                                break; 
                            default:
                                break;
                        }
                    }
                }
            })
        </script>
    </body>
</html>