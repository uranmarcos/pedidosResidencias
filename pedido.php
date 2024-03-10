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
        <link href="css/notificacion.css" rel="stylesheet"> 
        <link href="css/modal.css" rel="stylesheet"> 
        <!-- <script src="funciones/pdf.js" crossorigin="anonymous"></script> -->
    </head>
    <body>
        <div id="app">
            <?php require("componentes/header.html")?>
            
            <div class="container">
                <!-- START BREADCRUMB -->
                <div class="col-12 p-0">
                    <div class="breadcrumb">
                        <span class="pointer mx-2" @click="irAHome()">Inicio</span>  -  <span class="mx-2 grey"> Generar Pedido </span>
                    </div>
                </div>
                <!-- END BREADCRUMB -->            

                <!-- START DATOS ENVIO -->
                <div class="col-12 datosEnvio p-0" v-if="!modalDatosEnvio">
                    <div class="row">
                        <span class="col-12 col-md-4">
                            Voluntario: <b>{{envio.apellido}}, {{envio.nombre}}</b> 
                        </span>
                        <span class="col-12 col-md-4">
                            Residencia: <b>{{envio.residencia}}</b>
                        </span>
                        <span class="col-6 col-md-2">    
                            Casa: <b>{{envio.casa}}</b>
                        </span>
                        <span class="col-6 col-md-2 d-flex justify-content-end">    
                            <span @click="modalDatosEnvio = true" class="btnEditar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                </svg>
                            </span>
                        </span> 
                    </div>
                </div>
                <!-- END DATOS ENVIO -->  


                <div class="col-12">
                    <!-- START COMPONENTE LOADING BUSCANDO ARTICULOS -->
                    <div class="contenedorLoading" v-if="buscandoArticulos">
                        <div class="loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <!-- END COMPONENTE LOADING BUSCANDO ARTICULOS -->
                    
                    <div v-else>
                        <div v-if="articulos.length != 0" class="row contenedorPlanficaciones d-flex justify-content-around">
                            <table class="table mb-0 ">
                                <thead>
                                    <tr class="trHead">
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Articulo</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div>
                                        <tr v-for="articulo in articulos">
                                            <td>{{categorias.filter(e => e.id == articulo.categoria)[0].descripcion.toUpperCase()}}</td>
                                            <td>{{articulo.descripcion.toUpperCase()}} ({{articulo.medida}})</td>
                                            <td>
                                                <input
                                                    type="number" 
                                                    @keydown="limitarDigitos(articulo.cantidad, event)"
                                                    v-model="articulo.cantidad"
                                                >
                                                <button 
                                                    type="button" 
                                                    class="btnDelete" 
                                                    @click="articulo.cantidad = null" 
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                            <div class="botonesFooter row d-flex justify-content-between">                                
                                <button type="button" @click="modalVerPedido= true" class="col-12 col-md-6 botonFooter">
                                    VER PEDIDO
                                </button>
                                
                                <button type="button" class="col-12 col-md-6 botonFooter">
                                    GENERAR PEDIDO
                                </button>

                                <!-- <button 
                                    class="btn boton"
                                    v-if="confirmando" 
                                >
                                    <div class="confirmando">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </button> -->
                            </div>
                        </div> 
                            <div class="contenedorTabla" v-else>         
                                <span class="sinResultados">
                                    NO SE ENCONTRÓ RESULTADOS PARA MOSTRAR
                                </span>
                            </div>       
                        <!-- END TABLA pedidos -->
                        </div>
                    </div>

                    
                            
                    <!-- NOTIFICACION -->
                    <div role="alert" id="mitoast" aria-live="assertive" @mouseover="ocultarToast" aria-atomic="true" class="toast">
                        <div class="toast-header">
                            <!-- Nombre de la Aplicación -->
                            <div class="row tituloToast" id="tituloToast">
                                <strong class="mr-auto">{{tituloToast}}</strong>
                            </div>
                        </div>
                        <div class="toast-content">
                            <div class="row textoToast">
                                <strong >{{textoToast}}</strong>
                            </div>
                        </div>
                    </div>
                
                </div>
                <span class="ir-arriba" v-if="scroll" @click="irArriba">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                    </svg>
                </span>

                <!-- START MODAL DATOS ENVIO  -->
                <div v-if="modalDatosEnvio">
                    <div id="myModal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-header  d-flex justify-content-center">
                                <h5 class="modal-title" id="ModalLabel">
                                    DATOS DE ENVIO
                                </h5>
                            </div>
                            <div class="modal-body bodyModal row d-flex justify-content-center">
                                <div class="col-11 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Residencia
                                        </label>
                                        <input class="form-control" disabled v-model="envio.residencia">
                                    </div>
                                </div>

                                <div class="col-11 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Casa
                                        </label>
                                        <input class="form-control" disabled v-model="envio.casa">
                                    </div>
                                </div>

                                <div class="col-11 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Nombre Voluntario(*)
                                            <span class="errorLabel" v-if="errorNombre">Requerido</span>
                                        </label>
                                        <input class="form-control" v-model="envio.nombre">
                                    </div>
                                </div>

                                <div class="col-11 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Apellido Voluntario(*)
                                            <span class="errorLabel" v-if="errorApellido">Requerido</span>
                                        </label>
                                        <input class="form-control" v-model="envio.apellido">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer d-flex justify-content-center">                                
                                <button type="button" @click="aceptarDatosEnvio()" class="btn boton botonResponsive">
                                    ACEPTAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- END MODAL DATOS ENVIO-->

                <!-- START MODAL VER PEDIDO  -->
                <div v-if="modalVerPedido">
                    <div id="myModal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-header  d-flex justify-content-center">
                                <h5 class="modal-title" id="ModalLabel">
                                    ARTICULOS SELECCIONADOS
                                </h5>
                            </div>
                            <div class="modal-body bodyModal bodyModalVerPedido row d-flex justify-content-center">

                                <span v-for="articulo in articulos" style="height: 20px">
                                    <span v-if="articulo.cantidad != null"  class="itemListado">
                                        {{articulo.descripcion}} : {{articulo.cantidad}} 
                                        <span class="unidadItemListado">
                                            {{articulo.medida}}
                                        </span>
                                    </span>
                                </span>
                                <!-- <div class="col-11 mt-3">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Nombre Voluntario(*)
                                            <span class="errorLabel" v-if="errorNombre">Requerido</span>
                                        </label>
                                        <input class="form-control" v-model="envio.nombre">
                                    </div>
                                </div> -->

                            </div>

                            <div class="modal-footer d-flex justify-content-around">                                
                                <button type="button" @click="modalVerPedido = false" class="btn boton botonResponsive">
                                    CERRAR
                                </button>
                                <button type="button" @click="aceptarDatosEnvio()" class="btn boton botonResponsive">
                                    PEDIR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- END MODAL ENVIO-->
            </div>
            
        </div>


        <style>
            .breadcrumb{
                color: rgb(124, 69, 153);
                font-size:1em;
                padding:0 !important; 
                margin-top: 16px;
                text-transform: uppercase;
                border-bottom: solid 1px rgb(124, 69, 153);
            }
            .navegador {
                display: flex;
                justify-content: end;
            }
            .button{
                background-color: white;
                color: rgb(124, 69, 153);
                width: auto;
                text-transform: uppercase;
                height: 40px;
                border: solid 1px rgb(124, 69, 153);
                border-radius: 10px;
            }
            .button:hover{
                background-color: rgb(124, 69, 153);
                color: white;
            }
            .mr-2{
                margin-right: 10px;
            }
            .selectResidencia{
                width: 200px;
            }
        </style>
        <style scoped>
            .unidadItemListado{
                font-size: 12px !important;
            }
            .itemListado {
                font-size: 16px;
                z-index: 5;
                font-family: verdana;
                height: 20px;
                color: white;
                text-transform: uppercase
            }
            .itemListado:before {
                content: '✓';
            } 
            .bodyModalVerPedido{
                width: 100%;
                margin: auto;
                background-image:  url("./img/pizarron.jpg");
                background-repeat: no-repeat;
                background-size:cover;
                background-position: center;
                min-height: 200px;
                color: white;
                font-family: chalkduster;
            }
            thead{
                color:  #7C4599;
            }
            .botonesFooter{
                width: 100%;
                padding: 0;
                margin:0 auto;
            }
            .botonFooter{
                height: 40px;
                padding: 0;
                color:  #7C4599;
                font-weight: bolder;
                background: white;
                border: none;
            }
            .botonFooter:hover{
                border-bottom: solid 1px #7C4599;
            }
            .btnEditar{
                margin-right: 10px;
                color:  #7C4599;
            }
            .btnEditar:hover{
                cursor: pointer;
            }
            .datosEnvio{
                padding: 10px !important;
                border-radius: 5px;
                border: solid 1px grey;
            }
            /* ELIMINO BOTONES DEL INPUT NUMERICO */
            /* Para Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Para Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }
            .btnDelete{
                margin-left: 10px;
                color: rgb(238, 100, 100);;
                background: none;
                border: none;
            }
            .btnDelete:hover {
                color: rgb(254, 70, 70);
            }
            input{
                width: 60px;
                height: 30px;
                border-radius: 5px;
                text-align: center;
            }
            input:focus{
                outline: none !important;
                background-color: #eacdfa;
            }
            input.form-control{
                height:40px;
                border-radius: 5px;
                text-align: center;
            }
            .categoria{
                font-size: 0.8em;
            }
            .hide{
                display: none;
            }
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
            .contenedorABM{
                width: 100%;
                margin-top: 10px;
                margin-bottom: 20px;
                border: solid 1px #7C4599;
                border-radius: 5px;
            }
            .botonSmall{
                font-size: 12px;
                color: #7C4599;
            }
            .botonSmall:hover{
                font-size: 13px;
                color: #7C4599;
            }
            .botonSmallEye{
                width: 40px;
                height: 30px;
                border: solid 1px rgb(124, 69, 153);;
                font-size: 12px;
                color:rgb(124, 69, 153);
                padding: 0;
                margin: 5px 0;
            }
            .botonSmallEye:hover{
                font-size: 13px;
                background-color: rgb(124, 69, 153);
                color: white;
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
                text-align: center;
                color: #4F4E4E;
            }
            tr{
                border: solid 1px lightgrey;
            }
        </style>
        <script>
            var app = new Vue({
                el: "#app",
                components: {                
                },
                data: {
                    buscandoArticulos: false,
                    articulos: [],
                    categorias: [],
                    scroll: false,
                    tituloToast: null,
                    textoToast: null,
                    modalDatosEnvio: false,
                    envio: {
                        residencia: null,
                        casa: null,
                        nombre: null,
                        apellido: null
                    },
                    errorNombre: false,
                    errorApellido: false,
                    modalVerPedido: false
                },
                mounted () {
                    this.getCategorias();
                    this.getDatos();
                    // this.modalDatosEnvio = true;
                },
                beforeUpdate(){
                    window.onscroll = function (){
                        // Obtenemos la posicion del scroll en pantall
                        var scroll = document.documentElement.scrollTop || document.body.scrollTop;
                    }
                },
                methods:{
                    resetErrores () {
                        this.errorNombre = false;
                        this.errorApellido = false;
                    },
                    aceptarDatosEnvio () {
                        this.resetErrores();
                        let validacion = true;
                        if (!this.envio.nombre || (this.envio.nombre && this.envio.nombre.trim() == '')) {
                            this.errorNombre = true;
                            validacion = false;
                        }
                        if (!this.envio.apellido || (this.envio.apellido && this.envio.apellido.trim() == '')) {
                            this.errorApellido = true;
                            validacion = false;
                        }
                        if (validacion) {
                            this.modalDatosEnvio = false;
                        }

                    },
                    limitarDigitos (param, event) {
                        var teclasPermitidas = [8, 46, 37, 39];
                        if (param && param.length >= 4 && teclasPermitidas.indexOf(event.keyCode) === -1) {
                            event.preventDefault();
                        }
                    },
                    irA (destino) {
                        switch (destino) {
                            case "admin":
                                window.location.href = 'admin.php';    
                                break; 
                            default:
                                break;
                        }
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
                                    app.articulos = response.data.pedidos;
                                    app.articulos.forEach(element => {
                                        // element.cantidad = null
                                        app.$set(element, 'cantidad', null);
                                    });
                                } else {
                                    app.articulos = []
                                }
                            }
                        });
                    },
                    getCategorias() {
                        let formdata = new FormData();
                        formdata.append("opcion", 'categorias');
                        axios.post("funciones/admin.php?accion=getDatos", formdata)
                        .then(function(response){ 
                            if (response.data.error) {
                                app.mostrarToast("Error", response.data.mensaje);
                            } else {
                                if (response.data.pedidos != false) {
                                    app.categorias = response.data.pedidos;
                                } else {
                                    app.categorias = []
                                }
                            }
                        });
                    },
                    verPedido(id) {
                        let formdata = new FormData();
                        formdata.append("idPedido", id);
                    
                        axios.post("funciones/acciones.php?accion=verPedido", formdata)
                        .then(function(response){  
                            if (response.data.error) {
                                app.mostrarToast("Error", response.data.mensaje);
                            } else {
                                if (response.data.pedido != false) {
                                    app.armarPdf(response.data.pedido[0])
                                }
                            }
                        }).catch( error => {
                            app.mostrarToast("Error", "No se pudo visualizar el archivo. Intente nuevamente");
                        });
                    },
                    armarPdf(pedido){
                        pedido.pedido = pedido.pedido.replaceAll("**", "'")
                        let fecha = this.formatearFecha(pedido.fecha);
                        let merendero = pedido.merendero;
                        let voluntario = pedido.voluntario;
                        let direccion = pedido.direccion;
                        let ciudad = pedido.ciudad;
                        let provincia = pedido.provincia;
                        let codigoPostal = pedido.codigoPostal;
                        let telefono = pedido.telefono;
                        let destino = pedido.destino;
                        let articulosPedidos = pedido.pedido.split(";");
                        try {
                            // ARMADO PDF
                            const doc = new jsPDF();
                            var image = new Image()
                            const font = 'Arial';
                            const backgroundColor = '#F2F2F2'; // Color de fondo gris claro
                            doc.setFont(font);
        
                            image.src = 'img/logohor.jpg'
        
                            doc.addImage(image,80,10,50,16)
        
                            doc.setFontSize(11);
                            doc.text(175, 35, fecha );
                            
                            doc.setFontSize(12);
                            doc.text(20, 45, 'Nuevo pedido de: ');
                            doc.setFontSize(13);
                            doc.text(20, 53, merendero.toUpperCase());
                            
                            doc.setFontSize(13);
                            doc.setFillColor(backgroundColor);
                            doc.rect(20, 60, 173, 7, 'F'); // Rectángulo de fondo gris claro
                            doc.text(20, 65, 'DATOS DE ENVIO');
                            doc.line(20,67,193,67);
        
                            
                            doc.setFontSize(10);
        
                            doc.setFontType('bold');
                            doc.text(20, 75, 'Voluntario:');
        
                            doc.setFontType('regular');
                            doc.text(50, 75, voluntario);
        
        
                            doc.setFontType('bold');
                            doc.text(20, 82, 'Dirección: ');
        
                            doc.setFontType('regular');
                            doc.text(50, 82, direccion);    
        
                            doc.setFontType('bold');
                            doc.text(20, 89, 'Ciudad/Provincia: ');
        
                            doc.setFontType('regular');
                            doc.text(50, 89, ciudad + " / " +provincia);
                            
        
                            doc.setFontType('bold');
                            doc.text(20, 96, 'Código postal: ');
        
                            doc.setFontType('regular');
                            doc.text(50, 96, codigoPostal);
        
        
                            doc.setFontType('bold');
                            doc.text(20, 103, 'Teléfono:');
        
                            doc.setFontType('regular');
                            doc.text(50, 103, telefono);
        
        
                            doc.setFontSize(13);
                            doc.setFillColor(backgroundColor);
                            doc.rect(20, 110, 173, 7, 'F'); // Rectángulo de fondo gris claro
                            if (destino == "biblioteca") {
                                doc.text(20, 115, 'LIBROS PEDIDOS');
                            } else if (destino == "recursos") {
                                doc.text(20, 115, 'RECURSOS PEDIDOS');
                            } else if (destino == "meriendas") {
                                doc.text(20, 115, 'ARTICULOS PEDIDOS');
                            } else if (destino == "materiales") {
                                doc.text(20, 115, 'MATERIALES PEDIDOS');
                            } else {
                                doc.text(20, 115, 'LISTADO PEDIDO');
                            }
                            doc.line(20,117,193,117);

                            let contador = 1;
                            let posicionVertical = 125;
                            let currentPage = 1;
                            const maxWidth = doc.internal.pageSize.width - 30; // Ancho máximo del texto (margen izquierdo y derecho de 20)
                        
                            articulosPedidos.forEach(element => {
                                if (element.trim() != "" && element != null) {
                                    const lines = doc.splitTextToSize(contador + ".- " + element, maxWidth);
                                    if (posicionVertical + lines.length * 7 >= doc.internal.pageSize.height - 10) {
                                        doc.addPage();
                                        currentPage++;
                                        posicionVertical = 20; // Reiniciar la posición vertical en la nueva página
                                    }
                                    doc.setFontSize(10);
                                    lines.forEach(line => {
                                        doc.text(20, posicionVertical, line);
                                        posicionVertical += 7;
                                    });
                                    contador++;
                                }
                            })
                            var pdfData = doc.output('blob');

                            // Abrir el PDF en una nueva pestaña
                            var url = URL.createObjectURL(pdfData);
                            window.open(url);
                        } catch (error) {
                            this.mostrarToast("Error", "No se pudo visualizar el archivo. Intente nuevamente");
                        }
                    },
                    formatearFecha (fecha) {
                        let dia = fecha.split(" ")[0];
                        //let hora = fecha.split(" ")[1];
                        dia = dia.split("-").reverse().join("-");

                        return dia ;
                    },
                    irAHome () {
                        window.location.href = 'home.php';    
                    },
                    irArriba () {
                        window.scrollTo(0, 0);   
                    },
                            
                    // END FUNCIONES PLANIFICACION
                    mostrarToast(titulo, texto) {
                        app.tituloToast = titulo;
                        app.textoToast = texto;
                        var toast = document.getElementById("mitoast");
                        var tituloToast = document.getElementById("tituloToast");
                        toast.classList.remove("toast");
                        toast.classList.add("mostrar");
                        setTimeout(function(){ toast.classList.toggle("mostrar"); }, 10000);
                        if (titulo == 'Éxito') {
                            toast.classList.remove("bordeError");
                            toast.classList.add("bordeExito");
                            tituloToast.className = "exito";
                        } else {
                            toast.classList.remove("bordeExito");
                            toast.classList.add("bordeError");
                            tituloToast.className = "errorModal";
                        }
                    },
                    ocultarToast() {
                        this.tituloToast = "";
                        this.textoToast = "";
                        var toast = document.getElementById("mitoast");
                        toast.classList.remove("mostrar");
                        toast.classList.add("toast");
                    }
                }
            })
            window.addEventListener('scroll', function(evt) {
                let blur = window.scrollY / 10;
                if (blur == 0) {
                    app.scroll = false;
                } else {
                    app.scroll = true;
                }
            }, false);
        </script>
    </body>
</html>