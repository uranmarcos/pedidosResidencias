<?php
session_start();
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
        <!-- <link href="css/modal.css" rel="stylesheet"> 
        <script src="funciones/pdf.js" crossorigin="anonymous"></script> -->
    </head>
    <body>
        <div id="app">
            <?php require("componentes/header.html")?>
            
            
            <div class="container containerMenu">
                
                <!-- START BREADCRUMB -->
                <div class="col-12 p-0">
                    <div class="breadcrumb">
                        <span class="pointer mx-2" @click="irA('home')">Inicio</span>  -  <span class="mx-2 grey"> Admin </span>
                    </div>
                </div>
                <!-- END BREADCRUMB -->

                <!-- START OPCIONES -->
                <div class="col-12 p-0 contenedorOpciones mt-6">
                    <button class="opciones" @click="irA('residencias')">
                        Residencias
                    </button>
                    
                    <button class="opciones" @click="irA('categorias')">
                        Categorias
                    </button>
                    
                    <button class="opciones" @click="irA('articulos')">
                        Articulos
                    </button>

                    <button class="opciones" @click="irA('pedidos')">
                        Pedidos
                    </button>
                </div>
                <!-- END OPCIONES -->
            </div>
        </div>


        <style>
            .containerMenu{
                min-height: 85vh;
                margin: auto;
                display: flexbox;
                align-items: center;
                color: rgb(94, 93, 93);
            }
            .contenedorOpciones{
                display: flex;
                justify-content: space-between;
            }
            .opciones{
                flex-direction: column;
                border: solid 1px purple;
                border-radius: 10px;
                color: purple;
                text-transform: uppercase;
                text-align: center;
                width: 150px;
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .opciones:hover{
                cursor: pointer;
            }    
            .breadcrumb{
                color: rgb(124, 69, 153);
                font-size:1em;
                padding:0 !important; 
                margin-top: 16px;
                text-transform: uppercase;
                border-bottom: solid 1px rgb(124, 69, 153);
            }
            button{
                background-color: white;
                color: rgb(124, 69, 153);
                width: auto;
                text-transform: uppercase;
                height: 40px;
                border: solid 1px rgb(124, 69, 153);
                border-radius: 10px;
            }
            button:hover{
                background-color: rgb(124, 69, 153);
                color: white;
            }
            .mt-6{
                margin-top: 24px
            }
        </style>
        <script>
            var app = new Vue({
                el: "#app",
                components: {                
                },
                data: {
                },
                mounted () {
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
                            case "residencias":
                                window.location.href = 'adminResidencias.php';    
                                break; 
                            case "categorias":
                                window.location.href = 'adminCategorias.php';    
                                break; 
                            case "articulos":
                                window.location.href = 'adminArticulos.php';    
                                break; 
                            case "pedidos":
                                window.location.href = 'pedidos.php';    
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