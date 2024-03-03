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
                        <span class="pointer mx-2" @click="irA('home')">Inicio</span>  -  <span class="pointer mx-2" @click="irA('admin')"> Admin </span> -  <span class="mx-2 grey"> Articulos </span>
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
                    
                    <button class="opciones selected" @click="irA('articulos')">
                        Articulos
                    </button>

                    <button class="opciones" @click="irA('pedidos')">
                        Pedidos
                    </button>
                </div>
                <!-- END OPCIONES -->

               
                <!-- START COMPONENTE LOADING BUSCANDO pedidos -->
                <div class="contenedorLoading" v-if="buscando">
                    <div class="loading">
                        <div class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
                <!-- END COMPONENTE LOADING BUSCANDO pedidos -->
                        
                <!-- START TABLA -->
                <div v-else class="mt-6">
                    <div class="tituloTabla">
                        <span class="title">LISTADO DE ARTICULOS</span>
                        <span
                            class="btnCrear"
                            @click = "crear('crear')"
                        >
                            CREAR
                        </span>
                    </div>
                    <div v-if="datos.length != 0" class="row contenedorPlanficaciones d-flex justify-content-around">
                        <table class="table">
                            <thead>
                                <tr class="trHead">
                                    <th scope="col" v-for="columna in columnas">
                                        {{columna}}
                                        <button @click="ordenarTabla(columna)" v-if="columna != 'ID'">
                                            ↑↓
                                        </button>
                                    </th>
                                    <!--
                                    <th scope="col">Ver</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <div>
                                    <tr v-for="dato in datos">
                                        <div>
                                            <div>
                                                <td>{{dato.id}}</td>
                                                <td>{{dato.categoria.toUpperCase()}}</td>
                                                <td>{{dato.descripcion.toUpperCase()}}</td>
                                            </div>
                                        </div>
                                            <!-- <div v-if="seleccion == 'categorias'">
                                                <td v-if="seleccion == 'categorias'">{{dato.id}}</td>
                                                <td v-if="seleccion == 'categorias'">{{dato.descripcion.toUpperCase()}}</td>
                                            </div>
                                            
                                            <div v-if="seleccion == 'pedidos'">
                                                <td v-if="seleccion == 'pedidos'">{{dato.id}}</td>
                                                <td v-if="seleccion == 'pedidos'">{{dato.residencia.toUpperCase()}}</td>
                                                <td v-if="seleccion == 'pedidos'">{{dato.voluntario.toUpperCase()}}</td>
                                                <td v-if="seleccion == 'pedidos'">{{dato.fecha}}</td>
                                            </div> -->
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </div> 
                        <div class="contenedorTabla" v-else>         
                            <span class="sinResultados">
                                NO SE ENCONTRÓ RESULTADOS PARA MOSTRAR
                            </span>
                        </div>       
                    <!-- END TABLA -->
                    </div>
                </div>
                <!-- END TABLA -->

                <!-- MODAL RESIDENCIA -->
                <div v-if="modalResidencia">
                    <div id="myModal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-header  d-flex justify-content-center">
                                <h5 class="modal-title" id="ModalLabel">
                                    {{accionModal.toUpperCase}} RESIDENCIA
                                </h5>
                            </div>
                            <div class="modal-body row d-flex justify-content-center">
                                <div class="col-sm-12 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">Provincia(*)</label>
                                        <select class="form-control verCategorias">
                                            <option v-for="provincia in provincias">{{provincia}}</option>
                                        </select>
                                    </div>
                                    <span class="errorLabel" v-if="errorProvincia">Campo requerido</span>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                    <label for="nombre" class="labelCategoria">Provincia(*)</label>
                                        <input class="inputCategoria" :disabled="confirmCategorias" @input="errorNuevaCategoria = false" v-model="nuevaCategoria">
                                    </div>
                                    <span class="errorLabel" v-if="errorResidencia">Campo requerido</span>
                                </div>
                                
                            </div>

                            <!-- <div class="modal-body row d-flex justify-content-center">
                                <div class="col-sm-12 mt-3 d-flex justify-content-center">
                                    ¿Desea eliminar {{perfil == 'biblioteca' ? 'el libro' : perfil == 'recursos' ? 'el recurso' : 'la planificación'}}
                                </div>
                                <div class="col-sm-12 mt-3 d-flex justify-content-center">
                                    <b> {{objetoEliminable.nombre}}</b> ?    
                                </div>                             
                            </div> -->


                            <!-- <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn botonEliminar" @click="cancelarEliminar" >CANCELAR</button>
                                
                                <button type="button" @click="confirmarEliminar" class="botonGeneral" v-if="!eliminandoObjeto">
                                    CONFIRMAR
                                </button>

                                <button 
                                    class="botonGeneral"
                                    v-if="eliminandoObjeto" 
                                >
                                    <div class="loading">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </button>
                            </div> -->

                        </div>
                    </div>
                </div>    
                <!-- MODAL CATEGORIAS -->
            </div>
        </div>


        <style>
            th button {
                background-color: transparent;
                border: none;
                cursor: pointer;
                height: auto;
            }
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
            .tituloTabla{
                display: flex;
                justify-content: space-between;
            }
            .title{
                font-size: 16px;
                padding-left: 0px;
                color: rgb(124, 69, 153);;
            }
            .btnCrear{
                border: solid 1px rgb(124, 69, 153);
                padding: 0 12px;
                border-radius: 5px;
            }
            .btnCrear:hover{
                cursor: pointer;
            }
        </style>
        <style scoped>
            .ir-arriba {
                background-color: #7C4599;;
                width: 35px;
                height: 35px;
                font-size:20px;
                border-radius: 50%;
                color:#fff;
                cursor:pointer;
                position: fixed;
                display: flex;
                justify-content: center;
                align-items: center;
                bottom:20px;
                right:20%;
            }   
            .contenedorPlanficaciones{
                width: 100%;
                margin:10px auto;
            }
            #mitoast{
                z-index:60;
            }
            .sinResultados{
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px 10px 20px;
                text-align: center;
            }
            .contenedorTabla{
                color: rgb(124, 69, 153);
                border: solid 1px rgb(124, 69, 153);
                border-radius: 10px;
                padding: 10xp;
                margin-top: 16px;
                width: 100%;
            }    
            .table{
                font-size: 14px;
                text-align: center
            }
            tr{
                border: solid 1px lightgrey;
            }
            .selected{
                font-weight: bolder;
            }
        </style>
        <script>
            var app = new Vue({
                el: "#app",
                components: {                
                },
                data: {
                    buscando: false,
                    datos: [],
                    columnas: ['ID', 'CATEGORIA', 'DESCRIPCION'],
                    scroll: false,
                    tituloToast: null,
                    textoToast: null,
                    modalResidencia: false,
                    accionModal: null
                },
                mounted () {
                    this.getDatos();
                },
                beforeUpdate(){
                    window.onscroll = function (){
                        // Obtenemos la posicion del scroll en pantall
                        var scroll = document.documentElement.scrollTop || document.body.scrollTop;
                    }
                },
                methods:{
                    estaOrdenadoAscendentemente(atributo) {
                        for (let i = 1; i < this.datos.length; i++) {
                            if (this.datos[i - 1][atributo.toLowerCase()] > this.datos[i][atributo.toLowerCase()]) {
                                return false;
                            }
                        }
                        return true;
                    },
                    ordenarTabla(param) {
                        const ordenAscendente = this.estaOrdenadoAscendentemente(param);
                        if (ordenAscendente) {
                            this.datos.sort((a, b) => {
                                const valorA = a[param.toLowerCase()].toLowerCase();
                                const valorB = b[param.toLowerCase()].toLowerCase();
                                if (valorA < valorB) return 1;
                                if (valorA > valorB) return -1;
                                return 0;
                            });
                        } else { // Si no está ordenado de manera ascendente, ordenar de manera ascendente
                            this.datos.sort((a, b) => {
                                const valorA = a[param.toLowerCase()].toLowerCase();
                                const valorB = b[param.toLowerCase()].toLowerCase();
                                if (valorA < valorB) return -1;
                                if (valorA > valorB) return 1;
                                return 0;
                            });
                        }
                    },
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
                                window.location.href = 'home.php';    
                                break; 
                            default:
                                break;
                        }
                    },
                    crear (accion) {
                        this.modalResidencia = true;
                        this.accionModal = accion;
                    },
                    getDatos() {
                        this.buscando = true;
                        let formdata = new FormData();
                        formdata.append("opcion", 'articulos');
                        axios.post("funciones/admin.php?accion=getDatos", formdata)
                        .then(function(response){ 
                            app.buscando = false;
                            if (response.data.error) {
                                app.mostrarToast("Error", response.data.mensaje);
                            } else {
                                if (response.data.pedidos != false) {
                                    app.datos = response.data.pedidos;
                                } else {
                                    app.datos = []
                                }
                            }
                        });
                    }
                }
            })
        </script>
    </body>
</html>