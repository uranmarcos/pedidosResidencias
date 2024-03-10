<?php
session_start();
if (!$_SESSION["login"]) {
    header("Location: index.html");
}

$rol = $_SESSION["rol"];
$usuario = $_SESSION["usuario"];

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
        <link href="css/admin.css" rel="stylesheet"> 
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
                        <div class="col-12 col-md-6 p-0">
                            <span class="pointer mx-2" @click="irA('home')">Inicio</span>  -  <span class="pointer mx-2" @click="irA('admin')"> Admin </span> -  <span class="mx-2 grey"> Usuarios </span>
                        </div>    
                        <div class="col-12 col-md-6 p-0 d-flex spanUsuario justify-content-end">
                            <span> {{usuario}} </span>
                        </div>    
                    </div>
                </div>
                <!-- END BREADCRUMB -->

                <!-- START OPCIONES -->
                <div class="row p-0 contenedorOpciones mt-3">
                    <div v-for="opcion in opciones" class="col-3 contenedorOpcion">
                        <button class="opcion" :class="opcion == 'Usuarios' ? 'selected' : ''" @click="irA(opcion.toLowerCase())">
                            {{opcion}}
                        </button>
                    </div>
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
                        <span class="title">LISTADO DE USUARIOS</span>
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
                                        <button @click="ordenarTabla(columna)" v-if="columna == 'RESIDENCIA' || columna == 'USUARIO' || columna == 'ROL'">
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
                                            <!-- <td>{{dato.id}}</td> -->
                                            <td>{{dato.residencia}}</td>
                                            <td>{{dato.usuario}}</td>
                                            <td>{{dato.rol}}</td>
                                            <td>{{dato.casas == 0 ? '-' : dato.casas}}</td>
                                            <td>
                                                <span @click="editar(dato)" class="btnEditar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                    </svg>
                                                </span>
                                            </td>
                                        </div>
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
                <!-- END TABLA -->

                <!-- START MODAL  -->
                <div v-if="modal">
                    <div id="myModal" class="modal">
                        <div class="modal-content p-0">
                            <div class="modal-header  d-flex justify-content-center">
                                <h5 class="modal-title" id="ModalLabel">
                                    {{accion.toUpperCase()}} USUARIO
                                </h5>
                            </div>
                            <div class="modal-body bodyModal row d-flex justify-content-center">
                                <div class="col-sm-12 mt-1">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Provincia(*)
                                            <span class="errorLabel" v-if="errorProvincia">Requerido</span>
                                        </label>
                                        <select class="form-control" v-model="usuario.provincia">
                                            <option selected disabled>Seleccione...</option>
                                            <option v-for="provincia in provincias" :value="provincia">{{provincia}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-1">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Localidad(*)
                                            <span class="errorLabel" v-if="errorLocalidad">Requerido</span>
                                        </label>
                                        <input class="form-control" @input="errorProvincia = false" @keyup="crearUsuario(usuario.localidad)" v-model="usuario.localidad">
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 mt-1">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                        <label for="nombre" class="labelCategoria">
                                            Usuario(*)
                                            <span class="errorLabel" v-if="errorUsuario">Requerido</span>
                                        </label>
                                        <input class="form-control" v-model="usuario.usuario">
                                    </div>
                                </div>

                                <div class="row my-0 mx-0 px-0 d-flex justify-content-between">
                                    <div class="mt-1" :class="usuario.rol == 'residencia' ? 'col-8' : 'col-12'">
                                        <div class="row rowCategoria d-flex justify-space-around">
                                            <label for="nombre" class="labelCategoria">
                                                Rol(*)
                                            </label>
                                            <select class="form-control" v-model="usuario.rol">
                                                <option v-for="rol in roles" :value="rol">{{rol}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 mt-1" v-if="usuario.rol == 'residencia'">
                                        <div class="row rowCategoria d-flex justify-space-around">
                                            <label for="nombre" class="labelCategoria">
                                                Casas(*)
                                            </label>
                                            <select class="form-control" v-model="usuario.casas">
                                                <option :value="1">1</option>
                                                <option :value="2">2</option>
                                                <option :value="3">3</option>
                                                <option :value="4">4</option>
                                                <option :value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-1" v-if="accion == 'crear'">
                                    <div class="row rowCategoria d-flex justify-space-around">
                                    <label for="nombre" class="labelCategoria">Contraseña</label>
                                        <input class="form-control" disabled v-model="usuario.password">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer d-flex justify-content-between">                                
                                <button type="button" class="btn boton botonResponsive" @click="cancelar()" :disabled="confirmando">Cancelar</button>
                                
                                <button type="button" @click="confirmar()" class="btn boton botonResponsive" v-if="!confirmando">
                                    Confirmar
                                </button>

                                <button 
                                    class="btn boton"
                                    v-if="confirmando" 
                                >
                                    <div class="confirmando">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </button>
                            </div>

                            <!-- <div class="modal-body row d-flex justify-content-center">
                                <div class="col-sm-12 mt-1 d-flex justify-content-center">
                                    ¿Desea eliminar {{perfil == 'biblioteca' ? 'el libro' : perfil == 'recursos' ? 'el recurso' : 'la planificación'}}
                                </div>
                                <div class="col-sm-12 mt-1 d-flex justify-content-center">
                                    <b> {{objetoEliminable.nombre}}</b> ?    
                                </div>                             
                            </div> -->
                        </div>
                    </div>
                </div>    
                <!-- END MODAL -->

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
                <!-- NOTIFICACION -->
            </div>
        </div>
        <script>
            var app = new Vue({
                el: "#app",
                components: {                
                },
                data: {
                    buscando: false,
                    datos: [],
                    columnas: ['RESIDENCIA', 'USUARIO', 'ROL', 'CASAS', ''],
                    scroll: false,
                    tituloToast: null,
                    textoToast: null,
                    modal: false,
                    accion: null,
                    provincias: [
                        "Buenos Aires",
                        "CABA",
                        "Catamarca",
                        "Chaco",
                        "Chubut",
                        "Córdoba",
                        "Corrientes",
                        "Entre Ríos",
                        "Formosa",
                        "Jujuy",
                        "La Pampa",
                        "La Rioja",
                        "Mendoza",
                        "Misiones",
                        "Neuquén",
                        "Río Negro",
                        "Salta",
                        "San Juan",
                        "San Luis",
                        "Santa Cruz",
                        "Santa Fe",
                        "Santiago del Estero",
                        "Tierra del Fuego",
                        "Tucumán",
                        "GENERAL"
                    ],
                    errorProvincia: false,
                    errorLocalidad: false,
                    errorUsuario: false,
                    errorCasas: false,
                    usuario: {
                        id: null,
                        provincia: null,
                        localidad: null,
                        usuario: null,
                        rol: 'residencia',
                        casas: 1
                    },
                    confirmando: false,
                    roles: [
                        "residencia",
                        "admin",
                        "master"
                    ],
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
                    this.getDatos();
                },
                beforeUpdate(){
                    window.onscroll = function (){
                        // Obtenemos la posicion del scroll en pantall
                        var scroll = document.documentElement.scrollTop || document.body.scrollTop;
                    }
                },
                methods:{
                    cancelar () {
                        this.modal = false;
                        this.resetUsuario();
                    },
                    crearUsuario (param) {
                        if (param) {
                            const acentos = {
                                'á': 'a', 'é': 'e', 'í': 'i', 'ó': 'o', 'ú': 'u',
                                'Á': 'A', 'É': 'E', 'Í': 'I', 'Ó': 'O', 'Ú': 'U',
                                'à': 'a', 'è': 'e', 'ì': 'i', 'ò': 'o', 'ù': 'u',
                                'À': 'A', 'È': 'E', 'Ì': 'I', 'Ò': 'O', 'Ù': 'U',
                                'ä': 'a', 'ë': 'e', 'ï': 'i', 'ö': 'o', 'ü': 'u',
                                'Ä': 'A', 'Ë': 'E', 'Ï': 'I', 'Ö': 'O', 'Ü': 'U',
                            };

                            // Primero, reemplazo los caracteres acentuados por su equivalente sin acento
                            param = param.split('').map(letra => acentos[letra] || letra).join('');
                            // Reemplazo caracteres especiales
                            param = param.replace(/[^a-zA-Z]/g, "").toLowerCase().replaceAll(" ",'');;
                            this.usuario.usuario = param + "@fundacionsi.org.ar";
                            this.usuario.password = 30712506829;
                        }
                    },
                    resetErrores () {
                        this.errorProvincia = false;
                        this.errorLocalidad = false;
                        this.errorUsuario = false;
                    },
                    validarFormulario () {
                        this.resetErrores();
                        let validacion = true;
                        if (!this.usuario.provincia) {
                            this.errorProvincia = true;
                            validacion = false;
                        }
                        if (!this.usuario.localidad || this.usuario.localidad.trim() == '') {
                            this.errorLocalidad = true;
                            validacion = false;
                        }
                        if (!this.usuario.usuario || this.usuario.usuario.trim() == '') {
                            this.errorUsuario = true;
                            validacion = false;
                        }
                        return validacion;
                    },
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
                    },
                    confirmar () {
                        if (this.validarFormulario()) {
                            app.confirmando = true;
                            let formdata = new FormData();
                            formdata.append("provincia", app.usuario.provincia);
                            formdata.append("localidad", app.usuario.localidad);
                            formdata.append("usuario", app.usuario.usuario);
                            formdata.append("pass", app.usuario.password);
                            formdata.append("rol", app.usuario.rol);
                            formdata.append("casas", app.usuario.casas);

                            if (app.usuario.rol != 'residencia') {
                                formdata.append("casas", 0);
                            }



                            if (this.accion == 'crear') {
                                axios.post("funciones/admin.php?accion=crearUsuario", formdata)
                                .then(function(response){
                                    if (response.data.error) {
                                        app.mostrarToast("Error", response.data.mensaje);
                                    } else {
                                    app.mostrarToast("Éxito", response.data.mensaje);
                                    app.modal = false;
                                    app.resetUsuario();
                                    app.getDatos();
                                }
                                app.confirmando = false;
                                }).catch( error => {
                                    app.confirmando = false;
                                    app.mostrarToast("Error", "No se pudo crear el usuario");
                                })
                            }
                            if (this.accion == 'editar') {
                                formdata.append("id", app.usuario.id);
                                axios.post("funciones/admin.php?accion=editarUsuario", formdata)
                                .then(function(response){
                                    if (response.data.error) {
                                        app.mostrarToast("Error", response.data.mensaje);
                                    } else {
                                    app.mostrarToast("Éxito", response.data.mensaje);
                                    app.modal = false;
                                    app.resetUsuario();
                                    app.getDatos();
                                }
                                app.confirmando = false;
                                }).catch( error => {
                                    app.confirmando = false;
                                    app.mostrarToast("Error", "No se pudo editar el usuario");
                                })
                            }
                        }
                    },
                    resetUsuario () {
                        this.usuario.id = null;
                        this.usuario.provincia = null;
                        this.usuario.localidad = null;
                        this.usuario.usuario = null;
                        this.usuario.rol = 'residencia';
                        // this.usuario.password = null;
                        this.usuario.casas = 1;
                    },
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
                    },
                    crear (accion) {
                        this.modal = true;
                        this.accion = accion;
                    },
                    editar (dato) {
                        this.modal = true;
                        this.accion = 'editar';
                        this.usuario.id = dato.id;
                        this.usuario.provincia = dato.residencia.split(' - ')[0];
                        this.usuario.localidad = dato.residencia.split(' - ')[1];
                        this.usuario.usuario = dato.usuario;
                        this.usuario.rol = dato.rol;
                    },
                    getDatos() {
                        this.buscando = true;
                        let formdata = new FormData();
                        formdata.append("opcion", 'usuarios');
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